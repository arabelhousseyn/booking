<?php

namespace App\Models;

use App\Enums\GearBox;
use App\Enums\Motorisation;
use App\Enums\Status;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Vehicle extends Model implements HasMedia
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
        'places',
        'motorisation',
        'gearbox',
        'is_full',
        'payments_accepted',
        'availability_start_date',
        'availability_end_date',
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
        'motorisation' => Motorisation::class,
        'gearbox' => GearBox::class,
        'payments_accepted' => 'json',
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

    public function documents(): HasMany
    {
        return $this->hasMany(VehicleDocument::class, 'vehicle_id', 'id');
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
        return $this->getMedia('vehicle')->map(fn ($image) => "$image->original_url")->toArray();
    }

    public function getPhotoAttribute(): ?string
    {
        return $this->getFirstMedia('vehicle')?->getFullUrl();
    }

    public function getPhotoThumbAttribute(): ?string
    {
        return $this->getFirstMedia('vehicle')?->getFullUrl('thumb');
    }

    public function getPriceAttribute(): float
    {
        return round($this->attributes['price'], 2);
    }

    public function getIsUploadedDocumentsAttribute(): bool
    {
        return filled($this->documents()->get());
    }


    /**
     * functions
     */

    /**
     * Defining media collections for the Vehicle model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('vehicle')
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
