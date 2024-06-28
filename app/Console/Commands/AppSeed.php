<?php

namespace App\Console\Commands;

use Database\Seeders\BookFormatSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class AppSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(RoleSeeder $roleSeeder, UserSeeder $userSeeder, BookFormatSeeder $bookFormatSeeder)
    {
        $this->info('Seeding roles...');
        $roleSeeder->run();
        $this->info('Roles seeded successfully...');
        $this->info('Seeding users...');
        $userSeeder->run();
        $this->info('Users seeded successfully...');
        $this->info('Seeding book formats...');
        $bookFormatSeeder->run();
        $this->info('Book formats seeded successfully...');

        $this->info('App data seeded successfully.');
    }
}
