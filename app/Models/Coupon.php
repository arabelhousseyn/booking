<?php

namespace App\Models;

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasFactory, UUID, HasTranslations;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'code',
        'description',
        'value_type',
        'value',
        'type',
        'system_type',
        'start_date',
        'end_date',
        'usage_limit',
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
        'type' => CouponType::class,
        'system_type' => CouponSystemType::class,
        'status' => CouponStatus::class,
        'value_type' => CouponValueType::class,
    ];

    /**
     * translatable columns
     */

    public $translatable = ['description'];

    /**
     * relationships
     */

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }


    /**
     * functions
     */
}
