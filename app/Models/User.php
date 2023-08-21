<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\PaymentType;
use App\Exceptions\CoordinatesException;
use App\Exceptions\PaymentException;
use App\Support\ApplyCouponCodeBuilder;
use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use KMLaravel\GeographicalCalculator\Facade\GeoFacade;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Exception;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, UUID, Billable;


    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'country_code',
        'otp',
        'signup_step',
        'can_rent_house',
        'can_rent_vehicle',
        'coordinates',
        'validated_at',
        'validated_by',
        'password',
        'firebase_registration_token',
        'rib_bank_account',
        'dahabia_account',
    ];

    /**
     * hidden attributes
     */
    protected $hidden = [
        'password',
    ];

    /**
     * cast attributes
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'validated_at' => 'datetime',
        'can_rent_house' => 'boolean',
        'can_rent_vehicle' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     */
    protected $with = [
        'media',
    ];

    /**
     * relationships
     */

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'validated_by', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }

    public function reviews(): HasMany
    {

        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    /**
     * Accessors & mutators
     */

    public function getAvatarAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getFullUrl();
    }

    public function getAvatarThumbAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getFullUrl('thumb');
    }

    public function getIsValidatedAttribute(): bool
    {
        return !blank($this->attributes['validated_at']);
    }


    /**
     * functions
     */

    /**
     * Defining media collections for the User model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk('public')
            ->registerMediaConversions(function (Media $media) {
                {
                    $this->addMediaConversion('thumb')
                        ->width(80)
                        ->height(80);
                }
            });
    }

    public static function nearByVehicles(string $coordinates): Builder
    {
        $nearVehicleIds = [];
        $core = Core::select('KM')->first();

        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            try {
                $km = self::calculateDistance($vehicle->coordinates, $coordinates);

                if ($km['1-2']['km'] <= $core->KM) {
                    $nearVehicleIds[] = $vehicle->id;
                }
            } catch (Exception $exception) {
                continue;
            }
        }

        return Vehicle::query()->whereIn('id', $nearVehicleIds)->with('reviews');
    }

    public static function nearByHouses(string $coordinates): Builder
    {
        $nearHouseIds = [];
        $core = Core::select('KM')->first();

        $houses = House::all();

        foreach ($houses as $house) {
            try {
                $km = self::calculateDistance($house->coordinates, $coordinates);

                if ($km['1-2']['km'] <= $core->KM) {
                    $nearHouseIds[] = $house->id;
                }
            } catch (Exception $exception) {
                continue;
            }
        }

        return House::query()->whereIn('id', $nearHouseIds)->with('reviews');
    }

    private static function calculateDistance(string $location1, string $location2): array
    {
        $distance = GeoFacade::setOptions(['units' => ['km']])
            ->setPoint([explode(',', $location1)[0], explode(',', $location1)[1]])
            ->setPoint([explode(',', $location2)[0], explode(',', $location2)[1]])
            ->getDistance();

        GeoFacade::clearResult();

        return $distance;
    }

    public function CalculateBookingPrice(array $data): array
    {
        $days = Carbon::parse($data['end_date'])->diffInDays($data['start_date']);
        $core = Core::first();
        $commission = $core->commission;

        /** @var House|Vehicle $bookable */
        $bookable = Relation::$morphMap[$data['bookable_type']]::find($data['bookable_id']);

        $original_price = $bookable->price * $days;

        $original_price = (new ApplyCouponCodeBuilder(@$data['coupon_code'], $original_price, $data['bookable_type']))->calculate();

        [$dahabia_caution, $debit_card_caution] = Booking::retrieveCaution($data['bookable_type'], $core);

        $calculated_price = Booking::calculateCommission($original_price, $commission);
        $caution = ($data['payment_type'] == PaymentType::DAHABIA) ? $dahabia_caution : $debit_card_caution + $original_price;

        return [
            'original_price' => $original_price,
            'calculated_price' => $calculated_price,
            'commission' => $commission,
            'caution' => $caution,
            'seller_id' => $bookable->seller_id,
        ];
    }

    public function registerPayment(Booking $booking, string $return_url): array
    {
        $satimApi = config('app.satim_api');
        $response = Http::get("${satimApi}/register.do", [
            'userName' => config('app.satim_username'),
            'password' => config('app.satim_password'),
            'currency' => config('app.satim_currency'),
            'language' => app()->getLocale(),
            'amount' => $booking->caution,
            'orderNumber' => $booking->reference,
            'returnUrl' => $return_url,
        ]);

        if ($response->json()['errorCode'] != '0') {
            throw new PaymentException();
        }

        return $response->json();
    }

    public function confirmRegisteredPayment(string $order_id): array
    {
        $satimApi = config('app.satim_api');
        $response = Http::get("${satimApi}/confirmOrder.do", [
            'userName' => config('app.satim_username'),
            'password' => config('app.satim_password'),
            'language' => app()->getLocale(),
            'orderId' => $order_id,
        ]);

        if ($response->json()['ErrorCode'] != '0') {
            throw new PaymentException($response->json()['actionCodeDescription']);
        }

        return $response->json();
    }

    public static function coordinates($coordinates): string
    {
        if (filled($coordinates)) {
            return $coordinates;
        } else {
            if (auth()->check()) {
                return User::find(auth()->id())->coordinates;
            }
        }

        throw new CoordinatesException();
    }
}
