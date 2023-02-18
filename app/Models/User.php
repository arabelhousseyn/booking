<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, UUID;


    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_verified_at',
        'otp',
        'can_rent_house',
        'can_rent_vehicle',
        'coordinates',
        'validated_at',
        'validated_by',
        'password',
    ];

    /**
     * hidden attributes
     */
    protected $hidden = [
        'password',
    ];

    /**
     * cast attributes
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'validated_at' => 'datetime',
        'can_rent_house' => 'boolean',
        'can_rent_vehicle' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     */
    protected $with = [
        'media',
    ];

    /**
     * relationships
     */

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'validated_by', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class, 'user_id', 'id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }

    /**
     * Accessors & mutators
     */

    public function getAvatarAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getFullUrl();
    }

    public function getAvatarThumbAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getFullUrl('thumb');
    }


    /**
     * functions
     */

    /**
     * Defining media collections for the User model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk('public')
            ->registerMediaConversions(function (Media $media) {
                {
                    $this->addMediaConversion('thumb')
                        ->width(80)
                        ->height(80);
                }
            });
    }
}
