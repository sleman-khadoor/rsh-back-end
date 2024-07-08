<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogsCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = BlogCategory::factory(20)->create();
        $blogs = Blog::factory(10)->create();
        foreach($categories as $category) {
            foreach($blogs as $blog) {
                BlogsCategories::create([
                    'blog_category_id'=> $category->id,
                    'blog_id'=> $blog->id,
                ]);
            }
        }
    }
}
