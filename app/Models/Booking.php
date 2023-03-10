<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\ModelType;
use App\Enums\PaymentType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    use HasFactory, UUID;

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->status = BookingStatus::PENDING;
        });
    }

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'user_id',
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


    /**
     * functions
     */
}
