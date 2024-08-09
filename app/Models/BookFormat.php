<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookFormat extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title'];
    public $translatable = ['title'];
    public $timestamps = false;
}
