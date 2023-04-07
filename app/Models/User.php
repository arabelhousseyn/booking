<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\PaymentType;
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
use Illuminate\Support\Facades\DB;
use KMLaravel\GeographicalCalculator\Facade\GeoFacade;
use Laravel\Sanctum\HasApiTokens;
use PHPUnit\Exception;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, UUID;


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
        'can_rent_house',
        'can_rent_vehicle',
        'coordinates',
        'validated_at',
        'validated_by',
        'password',
        'firebase_registration_token',
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
        try {
            DB::beginTransaction();
            $has_caution = false;

            $days = Carbon::parse($data['end_date'])->diffInDays($data['start_date']);
            $core = Core::select(['commission', 'dahabia_caution', 'debit_card_caution'])->first();
            $commission = $core->commission;

            /** @var House|Vehicle $bookable */
            $bookable = Relation::$morphMap[$data['bookable_type']]::find($data['bookable_id']);

            $net_price = $bookable->price * $days;

            $net_price = (new ApplyCouponCodeBuilder(@$data['coupon_code'], $net_price, $data['bookable_type']))->calculate();

            if ($data['payment_type'] == PaymentType::DAHABIA) {
                if ($net_price <= $core->dahabia_caution) {
                    $total_price = $net_price;
                    $amount_to_pay = $net_price;
                } else {
                    $amount_not_paid = $net_price - $core->dahabia_caution;
                    $total_price = $amount_not_paid - (($amount_not_paid * $commission) / 100);
                    $amount_to_pay = $core->dahabia_caution;
                    $has_caution = true;
                }
            } elseif ($data['payment_type'] == PaymentType::VISA || $data['payment_type'] == PaymentType::MASTER_CARD) {
                $total_price = $net_price + $core->debit_card_caution;
                $amount_to_pay = $total_price;
                $has_caution = true;
            }

            DB::commit();

            $this->pay($amount_to_pay, $data['payment_type']);

            return [
                'net_price' => $net_price,
                'total_price' => $total_price,
                'commission' => $commission,
                'has_caution' => $has_caution,
                'seller_id' => $bookable->seller_id,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function pay(float $amount, string $type): void
    {
        // todo : implement the pay api's
    }
}
