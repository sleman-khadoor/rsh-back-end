<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Achievement extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, HasFilters;

    public $timestamps = false;
    protected $fillable = ['content'];
    public $translatable = ['content', 'slug'];

    protected static array $allowedFilters = ['content'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('content')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
