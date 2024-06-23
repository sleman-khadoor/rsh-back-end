<?php

namespace Database\Seeders;

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
        BookCategory::factory(20)->create();
    }
}
