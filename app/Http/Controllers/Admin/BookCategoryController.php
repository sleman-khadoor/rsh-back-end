<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Traits\HasChildRecords;
use App\Http\Controllers\Controller;
use Knuckles\Scribe\Attributes\Group;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\BookCategory\StoreBookCategoryRequest;
use App\Http\Requests\BookCategory\UpdateBookCategoryRequest;
use App\Http\Resources\BookCategory\AdminBookCategoryResource;


#[Group('Admin Endpoints')]
#[Subgroup('Book Category Management', 'APIs for managing Book Categories')]

class BookCategoryController extends Controller
{

    use HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminBookCategoryResource::class);
    }

    #[Endpoint('Get all Book Categories.')]
    #[QueryParam('filter[title]', 'string', 'filter Book Categroies by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $bookCategories = QueryBuilder::for(BookCategory::class)
                                ->allowedFilters(BookCategory::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($bookCategories);
    }

    #[Endpoint('Get Book Category by slug.')]
    #[UrlParam('slug', 'integer', 'The slug of the book category', true)]
    public function show(BookCategory $bookCategory) {

        return $this->resource($bookCategory);
    }

    #[Endpoint('Store Book Category.')]
    #[BodyParam('title', 'array', 'The title of the Book Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function store(StoreBookCategoryRequest $request) {

        $bookCategory = BookCategory::create($request->validated());

        return $this->resource($bookCategory, status:Response::HTTP_CREATED, method:'POST');
    }

    #[Endpoint('Update Book Category.')]
    #[UrlParam('slug', 'integer', 'The slug of the book category', true)]
    #[BodyParam('title', 'array', 'The title of the Book Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function update(UpdateBookCategoryRequest $request, BookCategory $bookCategory) {

        $bookCategory->update($request->validated());

        return $this->resource($bookCategory, method:'PUT');
    }

    #[Endpoint('Delete Book Category.')]
    #[UrlParam('slug', 'integer', 'The slug of the book category', true)]
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
