<?php

namespace App\Models;

use App\Enums\UserDocumentType;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocument extends Model
{
    use HasFactory, UUID;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'user_id',
        'document_type',
        'document_url',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [
        'document_type' => UserDocumentType::class,
    ];

    /**
     * relationships
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * functions
     */
}
