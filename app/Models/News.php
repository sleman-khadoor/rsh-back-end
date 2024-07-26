<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\SlugOptions;


class News extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, HasIncludes, HasFilters;

    public $timestamps = false;
    protected $fillable = ['title', 'content', 'cover_image'];
    public $translatable = ['title', 'content','slug'];

    protected static array $allowedFilters = ['title'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
