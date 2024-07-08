<?php

namespace App\Models;

use App\Models\Abstracts\RelationsAware;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model implements RelationsAware
{
    use HasFactory, HasTranslations, HasTranslatableSlug, HasFilters;

    public $timestamps = false;
    protected $fillable = ['title'];
    public $translatable = ['title', 'slug'];

    protected static array $allowedFilters = ['title'];


    public function blogs(): BelongsToMany {

        return $this->belongsToMany(Blog::class, 'blog_category');
    }

    public function relations(): array
    {
        return ['blogs'];
    }

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
