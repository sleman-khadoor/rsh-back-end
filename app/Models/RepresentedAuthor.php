<?php

namespace App\Models;

use App\Models\Abstracts\RelationsAware;
use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class RepresentedAuthor extends Model implements RelationsAware
{
    use HasFactory, HasTranslations, HasTranslatableSlug, HasIncludes, HasFilters;

    public $timestamps = false;
    protected $fillable = ['name', 'about', 'avatar'];
    public $translatable = ['name', 'about', 'slug'];

    protected static array $allowedFilters = ['name'];

    public function relations(): array
    {
        return [];
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
