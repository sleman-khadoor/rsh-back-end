<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
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
        $authors = Author::factory(20)->create();
        BookCategory::factory(20)->create();

        foreach($authors as $author) {

            Book::factory(2)->create(['author_id' => $author->id]);
        }
    }
}
