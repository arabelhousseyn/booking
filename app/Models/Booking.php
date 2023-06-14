<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\ModelType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Notifications\BookingDeclined;
use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Booking extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, UUID;

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->status = BookingStatus::PENDING;
            $model->payment_status = PaymentStatus::PENDING;
            $model->reference = $model->generateReference();
        });
    }

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'reference',
        'user_id',
        'seller_id',
        'satim_order_id',
        'payment_intent_id',
        'bookable_type',
        'bookable_id',
        'payment_type',
        'original_price',
        'calculated_price',
        'commission',
        'caution',
        'refund',
        'start_date',
        'end_date',
        'coupon_code',
        'note',
        'status',
        'payment_status',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'bookable_type' => ModelType::class,
        'payment_type' => PaymentType::class,
        'status' => BookingStatus::class,
        'payment_status' => PaymentStatus::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * relationships
     */

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    /**
     * Accessors & mutators
     */

    public function getFeedbackPhotosAttribute()
    {
        return $this->getMedia('reclamations')->map(fn ($image) => "$image->original_url");
    }

    public function getStartPhotosAttribute()
    {
        return $this->getMedia('start')->map(fn ($image) => "$image->original_url");
    }

    public function getEndPhotosAttribute()
    {
        return $this->getMedia('end')->map(fn ($image) => "$image->original_url");
    }

    /**
     * functions
     */

    private function generateReference(): string
    {
        $current_year = Carbon::now()->format('Y');
        $bookingNumber = Booking::whereYear('created_at', $current_year)->count() + 1;
        return "$current_year-B-$bookingNumber";
    }

    public function notifyCancellation(Collection $admins): void
    {
        $admins->each(function (Admin $admin) {
            $admin->notify(new BookingDeclined($this));
        });
    }

    public static function retrieveCaution(string $bookableType, Core $core): array // to be tested
    {
        if ($bookableType == ModelType::HOUSE) {
            return [$core->house_dahabia_caution, $core->house_debit_card_caution];
        } elseif ($bookableType == ModelType::VEHICLE) {
            return [$core->vehicle_dahabia_caution, $core->vehicle_debit_card_caution];
        }

        return [];
    }

    public static function calculateCommission(float $price, int $commission): float
    {
        return $price - (($price * $commission) / 100);
    }

    /**
     * Defining media collections for the User model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('reclamations')
            ->useDisk('public');

        $this->addMediaCollection('start')
            ->useDisk('public');

        $this->addMediaCollection('end')
            ->useDisk('public');
    }
}
