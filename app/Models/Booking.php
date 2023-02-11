<?php

namespace App\Models;

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
