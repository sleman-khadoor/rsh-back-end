<?php

namespace App\Models;

use App\Models\Book;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Abstracts\RelationsAware;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookCategory extends Model implements RelationsAware
{
    use HasFactory, HasTranslations, HasTranslatableSlug;

    public $timestamps = false;
    protected $fillable = ['title'];
    public $translatable = ['title', 'slug'];


    public function books(): BelongsToMany {

        return $this->belongsToMany(Book::class, 'book_category');
    }

    public function relations(): array
    {
        return ['books'];
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
