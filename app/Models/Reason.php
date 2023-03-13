<?php

namespace App\Models;

use App\Enums\ReasonTypes;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory, UUID;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'description',
        'type',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'type' => ReasonTypes::class,
    ];

    /**
     * relationships
     */


    /**
     * functions
     */
}
