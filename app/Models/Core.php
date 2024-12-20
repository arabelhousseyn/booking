<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Core extends Model
{
    use UUID;

    protected $table = 'core';

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'commission',
        'commission_updated_by',
        'KM',
        'vehicle_dahabia_caution',
        'vehicle_debit_card_caution',
        'house_dahabia_caution',
        'house_debit_card_caution',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'KM' => 'integer',
    ];

    /**
     * relationships
     */

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'commission_updated_by', 'id');
    }


    /**
     * functions
     */
}
