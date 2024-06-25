<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::factory(20)->create();
        BookCategory::factory(20)->create();
    }
}
