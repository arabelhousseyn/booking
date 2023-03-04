<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class WrongPasswordException extends Exception
{

    public function __construct(public string $state = 'current')
    {
    }

    public function report(): bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => trans('exceptions.wrong_password', ['state' => trans("nominations.$this->state")]),
        ], 400);
    }
}
