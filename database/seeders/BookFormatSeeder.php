<?php

namespace Database\Seeders;

use App\Models\BookFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookFormats = config('core-config.book_formats');

        foreach($bookFormats as $bookFormat) {

            BookFormat::create(['title' => $bookFormat]);
        }
    }
}
