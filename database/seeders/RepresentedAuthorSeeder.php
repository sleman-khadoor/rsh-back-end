<?php

namespace Database\Seeders;

use App\Models\RepresentedAuthor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepresentedAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RepresentedAuthor::factory(20)->create();
    }
}
