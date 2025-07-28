<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
use App\Models\User;
use App\Models\PropertyType;
use App\Models\PropertyCondition;
use App\Models\FurnishingStatus;
use App\Models\Country;
use App\Models\Location;
use App\Models\Landlord;



class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'bedrooms',
        'bathrooms',
        'size',
        'price',
        'status',
        'property_type_id',
        'property_condition_id',
        'furnishing_status_id',
        'country_id',
        'location_id',
        'agent_id',
        'landlord_id',
    ];

    // Relationships
    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function condition()
    {
        return $this->belongsTo(PropertyCondition::class, 'property_condition_id');
    }

    public function furnishingStatus()
    {
        return $this->belongsTo(FurnishingStatus::class, 'furnishing_status_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }

    // Accessors 
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    // Media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useFallbackUrl('/images/default-thumbnail.jpg');
    }

    /**
     * Register the media conversions for this model.
     *
     * @param Media|null $media
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail for listing cards (small, fast)
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 300, 200)
            ->sharpen(10)
            ->nonQueued();

        // Medium for detail pages or modals
        $this->addMediaConversion('medium')
            ->fit(Fit::Crop, 800, 600)
            ->optimize()
            ->nonQueued();

        // Large version (full width, gallery, or high-res download)
        $this->addMediaConversion('large')
            ->fit(Fit::Contain, 1600, 1200)
            ->quality(85)
            ->nonQueued();
    }


}
