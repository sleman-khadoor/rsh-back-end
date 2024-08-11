<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('core-config.roles');

        // create super admin user
        $superAdminData = config('core-config.users.super_admin');
        $superAdmin = User::factory()->create($superAdminData);
        $superAdmin->assignRole($roles['super_admin']); // assign all roles to the super admin user

        // Generate a user to simulate authenticated routes for scribe docs.
        if(app()->isLocal()) {

            User::factory()->create([
                'username' => 'scribe',
            ])->assignRole('super admin');
        }
    }
}
