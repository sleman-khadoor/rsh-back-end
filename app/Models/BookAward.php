<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookAward extends Model
{
    use HasFactory, HasTranslations, HasTranslatableSlug;

    public $timestamps = false;
    protected $fillable = ['title', 'book_id'];
    public $translatable = ['title', 'slug'];

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
