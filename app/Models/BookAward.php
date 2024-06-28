<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BookAward extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;
    protected $fillable = ['title', 'book_id'];
    public $translatable = ['title'];

}
