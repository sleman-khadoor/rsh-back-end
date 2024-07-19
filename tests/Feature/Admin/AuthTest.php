<?php

namespace Tests\Feature\Admin;


use Tests\TestCase;
use App\Models\Role;
use Tests\Feature\Admin\Traits\HasAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthTest extends TestCase
{
    use HasAdmin, RefreshDatabase;

    protected static string $BASE_URL = '/api/auth';

    protected function setup(): void
    {
        parent::setup();

        $this->setupAdmin(role: Role::getSuperAdminRole());

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(static::$BASE_URL. '/login', [
            'username' => $this->admin->username,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, $this->admin->tokens);
    }

    public function test_admin_cannot_login_with_invalid_password(): void
    {
        $response = $this->post(static::$BASE_URL. '/login', [
            'username' => $this->admin->username,
            'password' => 'password_wrong'
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, $this->admin->tokens);
    }

    public function test_admin_cannot_login_with_invalid_username(): void
    {
        $response = $this->post(static::$BASE_URL. '/login', [
            'username' => $this->admin->username . '_wrong',
            'password' => 'password_wrong'
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, $this->admin->tokens);
    }

    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post(static::$BASE_URL . '/logout');

        $response->assertStatus(200);
        $this->assertCount(0, $this->admin->tokens);
    }
}
