<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BookReview extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;
    protected $fillable = ['review', 'username', 'book_id'];
    public $translatable = ['review'];
}
