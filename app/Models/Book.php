<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug, HasIncludes, HasFilters;

    protected $fillable = ['title', 'abstract', 'ISBN', 'EISBN', 'printing_year', 'author_id'];
    public $translatable = ['title', 'abstract', 'slug'];

    protected static $allowedIncludes = ['bookCategories', 'formats', 'awards', 'reviews', 'author'];
    protected static $allowedFilters = ['title', 'ISBN', 'EISBN'];

    public function author(): BelongsTo {

        return $this->belongsTo(Author::class);
    }

    public function bookCategories(): BelongsToMany {

        return $this->belongsToMany(BookCategory::class, 'book_category');
    }

    public function formats(): BelongsToMany {

        return $this->belongsToMany(BookFormat::class, 'book_format');
    }

    public function awards(): HasMany {

        return $this->hasMany(BookAward::class);
    }

    public function reviews(): HasMany {

        return $this->hasMany(BookReview::class);
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
