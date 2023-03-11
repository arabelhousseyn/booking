<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\CoordinatesRequest;
use App\Http\Requests\UserFavoriteRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\UserFavoriteResource;
use App\Http\Resources\VehicleResource;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use App\Support\RecipientNotificationDispatcher;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use PasswordCanBeUpdated;

    public function listVehicles(CoordinatesRequest $request): JsonResource
    {
        $coordinates = (auth()->check()) ? User::find(auth()->id())->coordinates : $request->validated('coordinates');

        $vehicles = QueryBuilder::for(User::nearByVehicles($coordinates))
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
            ->whereNot('status', Status::PENDING)
            ->whereNot('status', Status::DECLINED)
            ->paginate();

        return VehicleResource::collection($vehicles);
    }

    public function listHouses(CoordinatesRequest $request): JsonResource
    {
        $coordinates = (auth()->check()) ? User::find(auth()->id())->coordinates : $request->validated('coordinates');

        $houses = QueryBuilder::for(User::nearByHouses($coordinates))
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
            ->whereNot('status', Status::PENDING)
            ->whereNot('status', Status::DECLINED)
            ->paginate();

        return HouseResource::collection($houses);
    }

    public function storeBooking(BookingRequest $request): BookingResource
    {
        /** @var House|Vehicle $bookable */
        $bookable = Relation::$morphMap[$request->validated('bookable_type')]::find($request->validated('bookable_id'));

        $this->authorize('create', [$bookable, auth()->user()]);

        $priceCalculated = auth()->user()->CalculateBookingPrice($request->validated());

        $booking = auth()->user()->bookings()->create(array_merge($priceCalculated, $request->safe()->only('payment_type', 'bookable_type', 'bookable_id', 'start_date', 'end_date')));

        $booking->load(['bookable']);

        (new RecipientNotificationDispatcher(trans('bookings.title_new_booking'), trans('bookings.body_new_booking'), $bookable->seller->firebase_registration_token, $booking))->send();

        return BookingResource::make($booking);
    }

    public function viewBooking(Booking $booking): BookingResource
    {
        $this->authorize('view', [$booking, auth()->user()]);

        $booking->load(['bookable']);

        return BookingResource::make($booking);
    }

    public function bookings(): JsonResource
    {
        $bookings = auth()->user()->bookings()->get();

        $bookings->loadMissing(['bookable']);

        return BookingResource::collection($bookings);
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
