<?php

namespace App\Traits;

use App\Exceptions\WrongPasswordException;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

trait PasswordCanBeUpdated
{
    public function updatePassword(UpdatePasswordRequest $request): Response
    {
        if (Hash::check($request->validated('old_password'), auth()->user()->getAuthPassword())) {
            $password = ['password' => Hash::make($request->validated('password'))];

            auth()->user()->update($password);

            return response()->noContent();
        }

        throw new WrongPasswordException('old');
    }
}
