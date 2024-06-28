<?php

namespace App\Models;

use App\Models\Abstracts\RelationsAware;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\SlugOptions;


class Author extends Model implements RelationsAware
{
    use HasFactory, HasTranslations, HasTranslatableSlug;

    public $timestamps = false;
    protected $fillable = ['name', 'about', 'avatar'];
    public $translatable = ['name', 'about', 'slug'];

    private static $allowedIncludes = ['books'];

    public function books(): HasMany {

        return $this->hasMany(Book::class);
    }

    public function relations(): array
    {
        return ['books'];
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

    public static function allowedIncludes(): array {

        return static::$allowedIncludes;
    }
}
