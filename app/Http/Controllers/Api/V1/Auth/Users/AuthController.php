<?php

namespace App\Http\Controllers\Api\V1\Auth\Users;

use App\Events\SignupUser;
use App\Exceptions\FileUploadedException;
use App\Exceptions\OtpValidatedException;
use App\Exceptions\SessionExpiredException;
use App\Exceptions\LoginException;
use App\Exceptions\WrongOtpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\OtpPhoneNumberRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserDocumentRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignupRequest;
use App\Http\Resources\UserResource;
use App\Mail\PasswordChanged;
use App\Mail\PasswordReset;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request): UserResource
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $request->user()->createToken(filter_var($request->headers->get('device_name') ?? config('app.name')));
            $user['token'] = $token->plainTextToken;

            return UserResource::make($user);
        }

        throw new LoginException();
    }

    public function signup(UserSignupRequest $request): UserResource
    {
        $password = ['password' => Hash::make($request->input('password'))];

        $user = User::create(array_merge($password, $request->safe()->only(['first_name', 'last_name', 'phone', 'email', 'coordinates', 'firebase_registration_token', 'country_code'])));

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        $user->refresh();
        $token = $user->createToken(filter_var($request->headers->get('device_name') ?? config('app.name')));
        $user['token'] = $token->plainTextToken;

        return UserResource::make($user);
    }

    public function otpPhoneNumber(OtpPhoneNumberRequest $request, User $user): Response
    {
        $user->update(['otp' => $request->validated('otp')]);

        return response()->noContent();
    }

    public function verifyPhoneNumber(OtpPhoneNumberRequest $request, User $user): Response
    {
        if (blank($user->otp) && !blank($user->phone_verified_at)) {
            throw new OtpValidatedException();
        }

        if ($user->otp == $request->validated('otp')) {
            $user->update(['otp' => null, 'phone_verified_at' => now(), 'signup_step' => '2']);
            return response()->noContent();
        }

        throw new WrongOtpException();
    }

    public function forgotPassword(ForgotPasswordRequest $request): Response
    {
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert([
            'email' => $request->input('email'),
        ], [
            'token' => $token,
            'created_at' => now(),
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();

        Mail::to($user->email)->send(new PasswordReset($user, $token));

        return response()->noContent();
    }

    public function resetPassword(ResetPasswordRequest $request): Response
    {
        throw_if(blank(DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->first()), new SessionExpiredException());

        DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->delete();

        $user = User::where('email', '=', $request->input('email'))->first();
        $user->update(['password' => Hash::make($request->input('password'))]);

        session()->put('user_password_changed', true);

        Mail::to($user->email)->send(new PasswordChanged($user));

        return response()->noContent();
    }

    public function uploadDocuments(UserDocumentRequest $request, User $user): Response
    {
        $documents = $request->validated('documents');

        try {
            foreach ($documents as $document) {
                $unique = uniqid().'.jpg';
                $document['document_image']->storeAs('public/documents', $unique);
                $image = env('APP_URL').'/storage/documents/'.$unique;
                $user->documents()->create(['document_type' => $document['document_type'], 'document_url' => $image]);
                $user->update(['signup_step' => '3']);
            }
        } catch (\Exception $exception) {
            throw new FileUploadedException();
        }

        $admins = Admin::all();
        $user->notifySignup($admins);
        event(new SignupUser($user->toArray()));

        return response()->noContent();
    }

    public function logout(): Response
    {
        Auth::user()->tokens()->delete();

        return response()->noContent();
    }
}
