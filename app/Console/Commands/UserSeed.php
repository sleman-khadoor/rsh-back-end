<?php

namespace App\Console\Commands;

use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class UserSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(RoleSeeder $roleSeeder, UserSeeder $userSeeder)
    {
        $this->info('Seeding roles...');
        $roleSeeder->run();
        $this->info('Roles seeded successfully...');
        $this->info('Seeding users...');
        $userSeeder->run();
        $this->info('Users seeded successfully...');
    }
}
