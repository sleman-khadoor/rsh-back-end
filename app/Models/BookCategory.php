<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Abstracts\RelationsAware;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookCategory extends Model implements RelationsAware
{
    use HasFactory, HasTranslations;

    public $timestamps = false;
    protected $fillable = ['title'];
    public $translatable = ['title'];


    public function books(): BelongsToMany {

        return $this->belongsToMany(Book::class, 'book_category');
    }

    public function relations(): array
    {
        return ['books'];
    }
}
