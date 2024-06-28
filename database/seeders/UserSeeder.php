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
        $superAdmin->assignRoles($roles); // assign all roles to the super admin user


        unset($roles['super_admin']); // remove super admin array from the roles list.

        foreach($roles as $key => $val) {
            $userData = config("core-config.users.$key");
            $user = User::factory()->create($userData);
            $user->assignRole($val);
        }


        // Generate a user to simulate authenticated routes for scribe docs.
        if(app()->isLocal()) {

            User::factory()->create([
                'username' => 'scribe',
            ])->assignRole('super admin');
        }
    }
}
