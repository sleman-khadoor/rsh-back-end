<?php

namespace App\Models;

use App\Traits\HasFilters;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactRequest extends Model
{
    use HasFactory, HasFilters, HasSlug;

    public $timestamps = false;
    protected $fillable = ['fullname', 'mobile', 'email', 'message'];
    protected static $allowedFilters = ['fullname', 'mobile', 'email'];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('fullname')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
