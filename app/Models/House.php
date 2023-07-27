<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class House extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, UUID;

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->status = Status::PENDING;
        });

        static::deleting(function (self $model) {
            $model->reviews()->delete();
        });
    }

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'seller_id',
        'title',
        'description',
        'coordinates',
        'price',
        'rooms',
        'has_wifi',
        'parking_station',
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
        'status' => Status::class,
        'parking_station' => 'boolean',
        'has_wifi' => 'boolean',
        'rooms' => 'integer',
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
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Accessors & mutators
     */

    public function getPhotosAttribute(): array
    {
        return $this->getMedia('house')->map(fn ($image) => "$image->original_url")->toArray();
    }

    public function getPhotoAttribute(): ?string
    {
        return $this->getFirstMedia('house')?->getFullUrl();
    }

    public function getPhotoThumbAttribute(): ?string
    {
        return $this->getFirstMedia('house')?->getFullUrl('thumb');
    }

    /**
     * functions
     */

    /**
     * Defining media collections for the House model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('house')
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
