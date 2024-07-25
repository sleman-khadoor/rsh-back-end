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

        // todo assert json structure
    }

    public function test_admin_can_get_all_book_category_by_slug(): void {

        $title = [
            'en' => 'test',
            'ar' => 'تست'
        ];

        $bookCategory = BookCategory::factory()->create(['title' => $title]);

        $response = $this->actingAs($this->admin)->get(static::$BASE_URL . '/' . $bookCategory->slug);

        $response->assertStatus(Response::HTTP_OK);

        // todo assert json structure
    }

    public function test_admin_can_store_book_category(): void {

        $title = [
            'en' => 'test',
            'ar' => 'تست'
        ];

        $response = $this->actingAs($this->admin)->post(static::$BASE_URL, ['title' => $title]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount('book_categories', 1);
    }
}
