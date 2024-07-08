<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsCategories extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table= 'blog_category';
    protected $fillable= ['blog_id', 'blog_category_id'];
}
