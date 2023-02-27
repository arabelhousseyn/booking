<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavoriteRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function StoreFavorite(UserFavoriteRequest $request): Response
    {
        auth('web')->user()->favorites()->create($request->validated());

        return response()->noContent();
    }
}
