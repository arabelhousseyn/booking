<?php

namespace App\Models;

use App\Enums\VehicleDocumentType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleDocument extends Model
{
    use HasFactory, UUID;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'vehicle_id',
        'document_type',
        'document_url',
        'expiry_date',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'document_type' => VehicleDocumentType::class,
        'expiry_date' => 'date',
    ];

    /**
     * relationships
     */

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }


    /**
     * functions
     */
}
