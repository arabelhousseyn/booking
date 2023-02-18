<?php

namespace App\Http\Controllers\Api\V1\Auth\Users;

use App\Exceptions\OtpValidatedException;
use App\Exceptions\SessionExpiredException;
use App\Exceptions\UserLoginException;
use App\Exceptions\WrongOtpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtpPhoneNumberRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignupRequest;
use App\Http\Resources\UserResource;
use App\Mail\PasswordChanged;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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

        throw new UserLoginException();
    }

    public function signup(UserSignupRequest $request): UserResource
    {
        $password = ['password' => Hash::make($request->input('password'))];

        $user = User::create(array_merge($password, $request->safe()->only(['first_name', 'last_name', 'phone', 'email', 'coordinates'])));

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

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
            $user->update(['otp' => null, 'phone_verified_at' => now()]);
            return response()->noContent();
        }

        throw new WrongOtpException();
    }

    public function forgotPassword(): JsonResponse
    {
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert([
            'email' => request()->user()->email,
        ], [
            'token' => $token,
            'created_at' => now(),
        ]);

        return response()->json(['data' => ['token' => $token]]);
    }

    public function resetPassword(ResetPasswordRequest $request): Response
    {
        throw_if(blank(DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->first()), new SessionExpiredException());

        DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->delete();

        $request->user()->update(['password' => Hash::make($request->input('password'))]);

        Mail::to($request->user()->email)->send(new PasswordChanged($request->user()));

        return response()->noContent();
    }

    public function logout(): Response
    {
        Auth::user()->tokens()->delete();

        return response()->noContent();
    }
}
