<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    use HasFactory, HasFilters, HasSlug, HasIncludes;

    public $timestamps = false;
    protected $fillable = ['fullname', 'mobile', 'email', 'description', 'service_name'];
    protected static array $allowedFilters = ['fullname', 'mobile', 'email'];
    protected static array $allowedIncludes = ['documents'];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('fullname')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function documents(): HasMany {

        return $this->hasMany(ServiceRequestDocument::class);
    }
}
