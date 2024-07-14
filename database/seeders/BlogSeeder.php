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
        BlogCategory::factory(5)->create();
        Blog::factory(20)->create();

        for($i = 1; $i <= 20; $i++) {
            BlogsCategories::create([
                'blog_category_id'=> rand(1, 5),
                'blog_id'=> $i,
            ]);
        }
    }
}
