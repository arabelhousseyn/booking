<?php

namespace App\Http\Controllers\Api\V1\Auth\Sellers;

use App\Exceptions\LoginException;
use App\Exceptions\OtpValidatedException;
use App\Exceptions\SessionExpiredException;
use App\Exceptions\WrongOtpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\OtpPhoneNumberRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SellerLoginRequest;
use App\Http\Requests\SellerSignupRequest;
use App\Http\Resources\SellerResource;
use App\Mail\PasswordChanged;
use App\Mail\PasswordReset;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(SellerLoginRequest $request): SellerResource
    {
        if (Auth::guard('seller')->attempt($request->validated())) {
            $seller = $request->user('seller');
            $token = $request->user('seller')->createToken(filter_var($request->headers->get('device_name') ?? config('app.name')));
            $seller['token'] = $token->plainTextToken;

            return SellerResource::make($seller);
        }

        throw new LoginException();
    }

    public function signup(SellerSignupRequest $request): SellerResource
    {
        $password = ['password' => Hash::make($request->input('password'))];

        $seller = Seller::create(array_merge($password, $request->safe()->only(['first_name', 'last_name', 'phone', 'email', 'firebase_registration_token', 'country_code'])));

        if ($request->hasFile('avatar')) {
            $seller->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        $seller->refresh();
        $token = $seller->createToken(filter_var($request->headers->get('device_name') ?? config('app.name')));
        $seller['token'] = $token->plainTextToken;

        return SellerResource::make($seller);
    }

    public function otpPhoneNumber(OtpPhoneNumberRequest $request, Seller $seller): Response
    {
        $seller->update(['otp' => $request->validated('otp')]);

        return response()->noContent();
    }

    public function verifyPhoneNumber(OtpPhoneNumberRequest $request, Seller $seller): Response
    {
        if (blank($seller->otp) && !blank($seller->phone_verified_at)) {
            throw new OtpValidatedException();
        }

        if ($seller->otp == $request->validated('otp')) {
            $seller->update(['otp' => null, 'phone_verified_at' => now()]);
            $seller->update(['signup_step' => '2']);
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

        $seller = Seller::where('email', '=', $request->input('email'))->first();

        Mail::to($seller->email)->send(new PasswordReset($seller, $token));

        return response()->noContent();
    }

    public function resetPassword(ResetPasswordRequest $request): Response
    {
        throw_if(blank(DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->first()), new SessionExpiredException());

        DB::table('password_resets')->where($request->safe()->only(['email', 'token']))->delete();

        $seller = Seller::where('email', '=', $request->input('email'))->first();
        $seller->update(['password' => Hash::make($request->input('password'))]);

        session()->put('user_password_changed', true);

        Mail::to($seller->email)->send(new PasswordChanged($seller));

        return response()->noContent();
    }

    public function logout(): Response
    {
        request()->user('sellers')->tokens()->delete();

        return response()->noContent();
    }
}
