<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class House extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, UUID;

    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->status = Status::PENDING;
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

    /**
     * Accessors & mutators
     */

    public function getPhotosAttribute(): MediaCollection
    {
        return $this->getMedia('photos');
    }

    public function getPhotoAttribute(): ?string
    {
        return $this->getFirstMedia('photos')?->getFullUrl();
    }

    public function getPhotoThumbAttribute(): ?string
    {
        return $this->getFirstMedia('photos')?->getFullUrl('thumb');
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
        $this->addMediaCollection('house')
            ->singleFile()
            ->useDisk('photos')
            ->registerMediaConversions(function (Media $media) {
                {
                    $this->addMediaConversion('thumb')
                        ->width(80)
                        ->height(80);
                }
            });
    }
}
