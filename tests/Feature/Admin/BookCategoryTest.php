<?php

namespace Tests\Feature\Admin;

use App\Models\BookCategory;
use Tests\TestCase;
use App\Models\Role;
use Tests\Feature\Admin\Traits\HasAdmin;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class BookCategoryTest extends TestCase
{
    use RefreshDatabase, HasAdmin;

    protected static string $BASE_URL = '/api/admin/book-categories';

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupAdmin(role: Role::getBooksAdminRole());

        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    public function test_admin_can_get_all_book_categories(): void {

        BookCategory::factory(10)->create();

        $response = $this->actingAs($this->admin)->get(static::$BASE_URL);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(10, 'data');
    }

    public function test_admin_can_get_all_book_category_by_slug(): void {

        $bookCategory = BookCategory::factory()->create(['title' => $this->getTitle()]);

        $response = $this->actingAs($this->admin)->get(static::$BASE_URL . '/' . $bookCategory->slug);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title' => [
                    'ar',
                    'en'
                ],
                'slug'
            ]
        ]);
    }

    public function test_admin_can_store_book_category(): void {

        $response = $this->actingAs($this->admin)->post(static::$BASE_URL, ['title' => $this->getTitle()]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title' => [
                    'ar',
                    'en'
                ],
                'slug'
            ]
        ]);
        $this->assertDatabaseCount('book_categories', 1);
    }

    public function test_admin_can_update_book_category(): void {

        $this->actingAs($this->admin)->post(static::$BASE_URL, ['title' => $this->getTitle()]);
        $bookCategory = BookCategory::find(1);

        $this->actingAs($this->admin)->put(static::$BASE_URL . '/' . $bookCategory->slug,
            [
                'title' => [
                    'en' => 'updated',
                    'ar' => 'معدل'
                ]
            ]
        );
        $bookCategory->refresh();

        $this->assertEquals('updated', $bookCategory->title);
    }

    public function test_admin_can_update_delete_category(): void {

        $this->actingAs($this->admin)->post(static::$BASE_URL, ['title' => $this->getTitle()]);
        $bookCategory = BookCategory::find(1);

        $this->actingAs($this->admin)->delete(static::$BASE_URL . '/' . $bookCategory->slug);

        $this->assertDatabaseCount('book_categories', 0);
    }

    protected function getTitle(): array {

        return  [
            'en' => 'test',
            'ar' => 'تست'
        ];
    }
}
