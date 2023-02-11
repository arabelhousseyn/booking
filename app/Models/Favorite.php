<?php

namespace App\Models;

use App\Enums\ModelType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    use HasFactory, UUID;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'user_id',
        'favorable_type',
        'favorable_id',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'favorable_type' => ModelType::class,
    ];

    /**
     * relationships
     */

    public function favorable(): MorphTo
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
