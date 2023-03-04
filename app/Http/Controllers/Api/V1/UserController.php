<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavoriteRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Resources\UserFavoriteResource;
use App\Models\Favorite;
use App\Models\User;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use PasswordCanBeUpdated;

    public function StoreFavorite(UserFavoriteRequest $request): Response
    {
        auth()->user()->favorites()->create($request->validated());

        return response()->noContent();
    }

    public function getFavorites(): JsonResource
    {
        $favorites = auth()->user()->favorites()->get();

        $favorites->loadMissing(['favorable']);

        return UserFavoriteResource::collection($favorites);
    }

    public function destroyFavorite(User $user, Favorite $favorite): Response
    {
        $favorite->delete();

        return response()->noContent();
    }

    public function updateProfile(UserUpdateProfileRequest $request): Response
    {
        auth()->user()->update($request->validated());

        return response()->noContent();
    }
}
