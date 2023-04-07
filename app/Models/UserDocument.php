<?php

namespace App\Models;

use App\Enums\UserDocumentStatus;
use App\Enums\UserDocumentType;
use App\Exceptions\FileUploadedException;
use App\Traits\UUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocument extends Model
{
    use HasFactory, UUID;


    protected static function booted()
    {
        parent::booted();

        static::creating(function (self $model) {
            $model->status = UserDocumentStatus::PENDING;
        });

        static::updated(function (self $model) {
            $user = $model->user;

            if ($user->documents()->where('status', '=', UserDocumentStatus::CONFIRMED)->count() >= 4) {
                $user->update(['validated_at' => Carbon::now(), 'validated_by' => auth()->id(), 'can_rent_vehicle' => 1]);
            }
        });
    }

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'user_id',
        'document_type',
        'document_url',
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
        'document_type' => UserDocumentType::class,
        'status' => UserDocumentStatus::class,
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
