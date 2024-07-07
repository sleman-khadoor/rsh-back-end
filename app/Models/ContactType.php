<?php

namespace App\Models;

use App\Models\Abstracts\RelationsAware;
use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactType extends Model implements RelationsAware
{
    use HasFactory, HasIncludes, HasFilters, HasSlug;

    public $timestamps = false;
    protected $fillable = ['title'];

    protected static array $allowedIncludes = ['contacts'];
    protected static array $allowedFilters = ['title'];

    public function contacts(): HasMany {

        return $this->hasMany(Contact::class);
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

    public function relations(): array {

        return ['contacts'];
    }
}
