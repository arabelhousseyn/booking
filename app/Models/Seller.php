<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Seller extends Authenticatable implements HasMedia
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
        'password',
        'firebase_registration_token',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * cast attributes
     */
    protected $casts = [];

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

    public function houses(): HasMany
    {
        return $this->hasMany(House::class, 'seller_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'seller_id', 'id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'seller_id', 'id');
    }

    /**
     * Accessors & mutators
     */

    public function getAvatarAttribute(): ?string
    {
        return $this->getFirstMedia('avatar')?->getFullUrl();
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
