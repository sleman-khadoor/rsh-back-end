<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, HasIncludes, HasFilters, HasSlug;

    public $timestamps = false;
    protected $fillable = ['contact_type_id', 'value'];

    protected static array $allowedIncludes = ['contactType'];
    protected static array $allowedFilters = ['value'];


    public function contactType(): BelongsTo {

        return $this->belongsTo(ContactType::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn(Contact $contact): string => $contact?->contactType?->slug.' '.$contact->value)
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
