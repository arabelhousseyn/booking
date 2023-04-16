<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\ModelType;
use App\Enums\PaymentType;
use App\Notifications\BookingDeclined;
use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class Booking extends Model
{
    use HasFactory, UUID;

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->status = BookingStatus::PENDING;
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
        'bookable_type',
        'bookable_id',
        'payment_type',
        'net_price',
        'total_price',
        'commission',
        'has_caution',
        'start_date',
        'end_date',
        'status',
        'coupon_code',
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
     * functions
     */

    private function generateReference(): string
    {
        $current_year = Carbon::now()->format('Y');
        $bookingNumber = Booking::whereYear('created_at', $current_year)->count() + 1;
        return "$current_year-B-$bookingNumber";
    }

    public function notifyCancelation(Collection $admins)
    {
        $admins->each(function (Admin $admin) {
            $admin->notify(new BookingDeclined($this));
        });
    }
}
