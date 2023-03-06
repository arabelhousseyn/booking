<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavoriteRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Resources\HouseResource;
use App\Http\Resources\UserFavoriteResource;
use App\Http\Resources\VehicleResource;
use App\Models\Favorite;
use App\Models\User;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use PasswordCanBeUpdated;

    public function listVehicles(Request $request): JsonResource
    {
        $vehicles = QueryBuilder::for(User::nearByVehicles())
            ->defaultSort('price')
            ->allowedFilters([
                'title',
                'description',
                'price',
                'places',
                'motorisation',
                'gearbox',
                'is_full',
                'status',
            ])
            ->allowedSorts(
                'title',
                'description',
                'price',
                'places',
                'motorisation',
                'gearbox',
                'is_full',
                'status',
            )
            ->paginate();

        return VehicleResource::collection($vehicles);
    }

    public function listHouses(): JsonResource
    {
        $houses = QueryBuilder::for(User::nearByHouses())
            ->defaultSort('price')
            ->allowedFilters([
                'title',
                'description',
                'price',
                'rooms',
                'has_wifi',
                'parking_station',
                'status',
            ])
            ->allowedSorts(
                'title',
                'description',
                'price',
                'rooms',
                'has_wifi',
                'parking_station',
                'status',
            )
            ->paginate();

        return HouseResource::collection($houses);
    }

    public function storeFavorite(UserFavoriteRequest $request): Response
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

        if ($request->hasFile('avatar')) {
            auth()->user()->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }

        return response()->noContent();
    }
}
