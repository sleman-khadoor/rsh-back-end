<?php

namespace Tests\Feature\Admin\Traits;

use App\Models\Role;
use App\Models\User;

trait HasAdmin {

    protected User $admin;

    public function setupAdmin(string $role, string $password = 'password') {

        $this->admin = User::factory()->create(['password' => $password]);

        $roleModel = Role::create(['name' => $role]);
        $this->admin->assignRole($roleModel);
    }
}
