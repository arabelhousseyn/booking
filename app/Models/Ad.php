<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ad extends Model implements HasMedia
{
    use InteractsWithMedia, UUID;

    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [];


    /**
     * cast attributes
     */
    protected $casts = [];


    /**
     * accessors and mutators
     */

    public function getPhotoAttribute(): string
    {
        return $this->getFirstMedia('ads')?->getFullUrl('medium');
    }


    /**
     * relationships
     */


    /**
     * functions
     */

    /**
     * Defining media collections for the Ad model.
     * https://spatie.be/docs/laravel-medialibrary/v9/working-with-media-collections/defining-media-collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ads')
            ->singleFile()
            ->useDisk('public')
            ->registerMediaConversions(function (Media $media) {
                {
                    $this->addMediaConversion('medium')
                        ->width(300)
                        ->height(250);
                }
            });
    }
}
