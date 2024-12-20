<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BookingStatus;
use App\Enums\CouponStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\ReasonTypes;
use App\Enums\Status;
use App\Events\BookingDeclined;
use App\Events\UserDispute;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingPaymentStatusRequest;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\ConfirmSatimRegistredOrderRequest;
use App\Http\Requests\DisputeRequest;
use App\Http\Requests\GetPropertyRequest;
use App\Http\Requests\GetReasonsRequest;
use App\Http\Requests\StoreBookingStateRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UserFavoriteRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Resources\AdResource;
use App\Http\Resources\BookingListResource;
use App\Http\Resources\BookingResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\HouseResource;
use App\Http\Resources\ReasonCompactResource;
use App\Http\Resources\UserFavoriteResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehicleResource;
use App\Models\Ad;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Favorite;
use App\Models\House;
use App\Models\Reason;
use App\Models\User;
use App\Models\Vehicle;
use App\Support\Filters\MinMaxPriceFilter;
use App\Support\RecipientNotificationDispatcher;
use App\Traits\PasswordCanBeUpdated;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use PasswordCanBeUpdated;

    public function listVehicles(GetPropertyRequest $request): JsonResource
    {
        $coordinates = User::coordinates($request->validated('coordinates'));

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
                'availability_start_date',
                'availability_end_date',
                'status',
                AllowedFilter::custom('custom_price', new MinMaxPriceFilter)
            ])
            ->allowedSorts(
                'title',
                'description',
                'price',
                'places',
                'motorisation',
                'gearbox',
                'is_full',
                'availability_start_date',
                'availability_end_date',
                'status',
            )
            ->whereNot('status', Status::PENDING)
            ->whereNot('status', Status::DECLINED)
            ->where('availability_start_date', '<=', $request->validated('start_date'))
            ->where('availability_end_date', '>=', $request->validated('end_date'))
            ->paginate();

        return VehicleResource::collection($vehicles);
    }

    public function listHouses(GetPropertyRequest $request): JsonResource
    {
        $coordinates = User::coordinates($request->validated('coordinates'));

        $houses = QueryBuilder::for(User::nearByHouses($coordinates))
            ->defaultSort('price')
            ->allowedFilters([
                'title',
                'description',
                'price',
                'rooms',
                'has_wifi',
                'parking_station',
                'availability_start_date',
                'availability_end_date',
                'status',
                AllowedFilter::custom('custom_price', new MinMaxPriceFilter)
            ])
            ->allowedSorts(
                'title',
                'description',
                'price',
                'rooms',
                'has_wifi',
                'parking_station',
                'availability_start_date',
                'availability_end_date',
                'status',
            )
            ->whereNot('status', Status::PENDING)
            ->whereNot('status', Status::DECLINED)
            ->where('availability_start_date', '<=', $request->validated('start_date'))
            ->where('availability_end_date', '>=', $request->validated('end_date'))
            ->paginate();

        return HouseResource::collection($houses);
    }

    public function showVehicle(Vehicle $vehicle): VehicleResource
    {
        $vehicle->load(['seller', 'reviews']);

        return VehicleResource::make($vehicle);
    }

    public function showHouse(House $house): HouseResource
    {
        $house->load(['seller', 'reviews']);

        return HouseResource::make($house);
    }

    public function storeBooking(BookingRequest $request): BookingResource
    {
        /** @var House|Vehicle $bookable */
        $bookable = Relation::$morphMap[$request->validated('bookable_type')]::find($request->validated('bookable_id'));

        $satimPaymentRegistration = [];
        $stripePayment = [];

        $this->authorize('create', [$bookable, auth()->user()]);

        try {
            DB::beginTransaction();

            $priceCalculated = auth()->user()->CalculateBookingPrice($request->validated());

            /** @var Booking $booking */
            $booking = auth()->user()->bookings()->create(array_merge($priceCalculated, $request->safe()->only('payment_type', 'bookable_type', 'bookable_id', 'start_date', 'end_date', 'coupon_code')));

            if ($request->validated('payment_type') == PaymentType::DAHABIA) {
                $satimPaymentRegistration = auth()->user()->registerPayment($booking, $request->validated('return_url'));
                $booking->update(['satim_order_id' => $satimPaymentRegistration['orderId']]);
                $booking->update(['payment_details' => $satimPaymentRegistration]);
            } elseif ($request->validated('payment_type') == PaymentType::VISA || $request->validated('payment_type') == PaymentType::MASTER_CARD) {
                $stripePayment['stripe_url'] = route('stripe.payment', [auth()->user(), $booking]);
                $booking->update(['payment_details' => $stripePayment]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        $booking->load(['bookable']);

        (new RecipientNotificationDispatcher(trans('bookings.title_new_booking'), trans('bookings.body_new_booking'), $bookable->seller->firebase_registration_token, $booking))->send();

        return BookingResource::make($booking, $satimPaymentRegistration, $stripePayment);
    }

    public function viewBooking(Booking $booking): BookingResource
    {
        $this->authorize('view', [$booking, auth()->user()]);

        $booking->load(['bookable','seller']);

        return BookingResource::make($booking, [], []);
    }

    public function declineBooking(Booking $booking): Response
    {
        $this->authorize('decline', [$booking, auth()->user()]);

        $booking->update(['status' => BookingStatus::DECLINED]);

        $booking->bookable()->update(['status' => Status::PUBLISHED]);

        $admins = Admin::all();

        $booking->notifyCancellation($admins);

        event(new BookingDeclined($booking->toArray()));

        return response()->noContent();
    }

    public function bookings(): JsonResource
    {
        $bookings = auth()->user()->bookings()->get();

        $bookings->loadMissing(['bookable.seller', 'user']);

        return BookingListResource::collection($bookings);
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

    public function profile(): UserResource
    {
        $user = auth()->user();

        return UserResource::make($user);
    }

    public function storeReview(StoreReviewRequest $request): Response
    {
        auth()->user()->reviews()->create($request->validated());

        return response()->noContent();
    }

    public function reasons(GetReasonsRequest $request): JsonResource
    {
        $reasons = Reason::where('type', '=', $request->validated('type'))
            ->Orwhere('type', '=', ReasonTypes::ALL)
            ->get();

        return ReasonCompactResource::collection($reasons);
    }

    public function coupons(): JsonResource
    {
        $coupons = Coupon::whereNot('status', '=', CouponStatus::INACTIVE)->get();

        return CouponResource::collection($coupons);
    }

    public function ads(): JsonResource
    {
        $ads = Ad::all();

        return AdResource::collection($ads);
    }

    public function bookingState(StoreBookingStateRequest $request, Booking $booking): Response
    {
        $booking->addMultipleMediaFromRequest(['images'])
            ->each(function ($fileAdder) use ($request) {
                $fileAdder->toMediaCollection($request->validated('state'));
            });

        return response()->noContent();
    }

    public function bookingPaymentStatus(BookingPaymentStatusRequest $request, Booking $booking): Response
    {
        /** @var House|Vehicle $bookable */
        $bookable = Relation::$morphMap[$booking->bookable_type]::find($booking->bookable_id);

        $booking->update($request->validated());

        $bookable->update(['status' => Status::BOOKED]);

        return response()->noContent();
    }

    public function confirmSatimRegistredOrder(ConfirmSatimRegistredOrderRequest $request, Booking $booking): Response
    {
        $this->authorize('satim', [$booking, $request->input('order_id')]);

        auth()->user()->confirmRegisteredPayment($request->validated('order_id'));

        $booking->update(['payment_status' => PaymentStatus::PAID]);

        return response()->noContent();
    }

    public function openDispute(DisputeRequest $request, Booking $booking)
    {
        $uniqid = uniqid();
        $image = $request->file('image')->storeAs('dispute', $uniqid . '.jpg');
        $image = config('app.url') . $image;

        event(new UserDispute($request->input('note'), $image, auth()->user(), $booking->toArray()));

        $admins  = Admin::all();
        $booking->notifyUserDispute($admins, $request->input('note'), auth()->user(), $booking);

        return response()->noContent();
    }
}
