<?php

namespace Tests\Feature\Admin;

use App\Models\Author;
use App\Models\BookCategory;
use Tests\TestCase;
use App\Models\Role;
use Tests\Feature\Admin\Traits\HasAdmin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class AuthorTest extends TestCase
{
    use RefreshDatabase, HasAdmin;

    protected static string $BASE_URL = '/api/admin/authors';

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupAdmin(role: Role::getBooksAdminRole());

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    public function test_admin_can_get_all_authors(): void {

        Author::factory(10)->create();

        $response = $this->actingAs($this->admin)->get(static::$BASE_URL);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(10, 'data');
    }

    public function test_admin_can_get_author_by_slug(): void {

        $author = Author::factory()->create(['name' => $this->getData()['name']]);

        $response = $this->actingAs($this->admin)->get(static::$BASE_URL . '/' . $author->slug);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name' => [
                    'ar',
                    'en'
                ],
                'about',
                'slug'
            ]
        ]);
    }

    public function test_admin_can_store_author(): void {

        $response = $this->actingAs($this->admin)->post(static::$BASE_URL, $this->getData());

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name' => [
                    'ar',
                    'en'
                ],
                'about',
                'slug'
            ]
        ]);
        $this->assertDatabaseCount('authors', 1);
    }

    public function test_admin_can_update_author(): void {

        $this->actingAs($this->admin)->post(static::$BASE_URL, $this->getData());
        $author = Author::find(1);

        $response = $this->actingAs($this->admin)->put(static::$BASE_URL . '/' . $author->slug,
            [
                'name' => [
                    'en' => 'updated',
                    'ar' => 'معدل'
                ],
                'about' => $this->getData()['about']
            ]
        );

        $author->refresh();

        $this->assertEquals('updated', $author->name);
    }

    public function test_admin_can_delete_author(): void {

        $this->actingAs($this->admin)->post(static::$BASE_URL, $this->getData());
        $author = Author::find(1);

        $this->actingAs($this->admin)->delete(static::$BASE_URL . '/' . $author->slug);

        $this->assertDatabaseCount('authors', 0);
    }

    protected function getData(): array {

        return  [
            'name' => [
                'en' => 'test',
                'ar' => 'تست'
            ],
            'about' => [
                'en' => 'test',
                'ar' => 'تست'
            ]
        ];
    }
}
