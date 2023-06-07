<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class PaymentException extends Exception
{
    public function __construct(string $message = "", int $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function report(): bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => (filled($this->message)) ? $this->message : trans('exceptions.payment_invalid'),
        ], 400);
    }
}
