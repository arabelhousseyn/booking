<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class OtpValidatedException extends Exception
{
    public function report(): bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => trans('exceptions.otp_validated'),
        ], 400);
    }
}
