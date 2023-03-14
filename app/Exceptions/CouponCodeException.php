<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CouponCodeException extends Exception
{
    public function report(): bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => trans('exceptions.coupon_code_invalid'),
        ], 400);
    }
}
