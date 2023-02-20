<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginException extends Exception
{
    public function report(): bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => trans('exceptions.user_login'),
        ], 400);
    }
}
