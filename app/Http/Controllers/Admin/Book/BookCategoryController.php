<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookCategoryRequest;
use App\Http\Requests\Book\UpdateBookCategoryRequest;
use App\Http\Resources\Book\BookCategory\AdminBookCategoryResource;
use App\Models\BookCategory;
use App\Traits\HasChildRecords;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;


#[Group('Admin Endpoints')]
#[Subgroup('Book Management', 'APIs for managing Book Categories')]

class BookCategoryController extends Controller
{

    use HasChildRecords;

    #[Endpoint('Get all Book Categories.')]
    #[QueryParam('filter[title]', 'string', 'filter Book Categroies by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $bookCategories = QueryBuilder::for(BookCategory::class)
                                ->allowedFilters(['title'])
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return AdminBookCategoryResource::collection($bookCategories);
    }

    #[Endpoint('Get Book Category by id.')]
    #[UrlParam('id', 'integer', 'The ID of the book category', true)]
    public function show(BookCategory $bookCategory) {

        return AdminBookCategoryResource::make($bookCategory);
    }

    #[Endpoint('Store Book Category.')]
    #[BodyParam('title', 'array', 'The title of the Book Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function store(StoreBookCategoryRequest $request) {

        $bookCategory = BookCategory::create([
            'title' => [
                'en' => $request->validated('title.en'),
                'ar' => $request->validated('title.ar'),
            ]
        ]);

        return AdminBookCategoryResource::make($bookCategory);
    }

    #[Endpoint('Update Book Category.')]
    #[UrlParam('id', 'integer', 'The ID of the book category', true)]
    #[BodyParam('title', 'array', 'The title of the Book Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function update(UpdateBookCategoryRequest $request, BookCategory $bookCategory) {

        $bookCategory->update([
            'title' => [
                'en' => $request->validated('title.en'),
                'ar' => $request->validated('title.ar'),
            ]
        ]);

        return AdminBookCategoryResource::make($bookCategory);
    }

    #[Endpoint('Delete Book Category.')]
    #[UrlParam('id', 'integer', 'The ID of the book category', true)]
    public function destroy(BookCategory $bookCategory) {

        if($this->hasChildRecords($bookCategory)) {

            return $this->error(
                    Response::HTTP_CONFLICT,
                    config('response-messages.crud.record_has_childs')
                );
        }

        $bookCategory->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
