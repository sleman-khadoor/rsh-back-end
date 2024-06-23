<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class BookCategory extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;
    protected $fillable = ['title'];
    public $translatable = ['title'];


    public function books(): BelongsToMany {

        return $this->belongsToMany(Book::class, 'book_category');
    }
}
