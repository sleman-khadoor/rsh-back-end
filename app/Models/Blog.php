<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasFactory, HasIncludes, HasFilters, HasSlug;

    protected $fillable = ['title', 'content', 'writer', 'date', 'lang'];
    public $translatable = [];

    protected static $allowedIncludes = ['blogCategories'];
    protected static $allowedFilters = ['title', 'writer'];

    public function blogCategories(): BelongsToMany {

        return $this->belongsToMany(BookCategory::class, 'blog_category', 'blog_id','blog_category_id');
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
    }}
