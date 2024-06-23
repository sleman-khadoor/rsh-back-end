<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed app roles
        (new RoleSeeder)->run();

        // seed users
        (new UserSeeder)->run();

        // seed books
        (new BookSeeder)->run();
    }
}
