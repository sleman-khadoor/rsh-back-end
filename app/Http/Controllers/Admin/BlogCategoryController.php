<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategory\StoreBlogCategoryRequest;
use App\Http\Requests\BlogCategory\UpdateBlogCategoryRequest;
use App\Http\Resources\BlogCategory\AdminBlogCategoryResource;
use App\Models\BlogCategory;
use App\Traits\HasChildRecords;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Admin Endpoints')]
#[Subgroup('Blog Category Management', 'APIs for managing Blog Categories')]
class BlogCategoryController extends Controller
{

    use HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminBlogCategoryResource::class);
    }

    #[Endpoint('Get all Blog Categories.')]
    #[QueryParam('filter[title]', 'string', 'filter Blog Categroies by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $blogCategories = QueryBuilder::for(BlogCategory::class)
                                ->allowedFilters(BlogCategory::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($blogCategories);
    }

    #[Endpoint('Get Blog Category by id.')]
    #[UrlParam('id', 'integer', 'The ID of the Blog category', true)]
    public function show(BlogCategory $BlogCategory) {

        return $this->resource($BlogCategory);
    }

    #[Endpoint('Store Blog Category.')]
    #[BodyParam('title', 'array', 'The title of the Blog Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function store(StoreBlogCategoryRequest $request) {

        $blogCategory = BlogCategory::create($request->validated());

        return $this->resource($blogCategory, method:'POST');
    }

    #[Endpoint('Update Blog Category.')]
    #[UrlParam('id', 'integer', 'The ID of the Blog category', true)]
    #[BodyParam('title', 'array', 'The title of the Blog Category.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory) {

        $blogCategory->update($request->validated());

        return $this->resource($blogCategory, method:'PUT');
    }

    #[Endpoint('Delete Blog Category.')]
    #[UrlParam('id', 'integer', 'The ID of the Blog category', true)]
    public function destroy(BlogCategory $blogCategory) {

        if($this->hasChildRecords($blogCategory)) {
            return $this->error(
                    Response::HTTP_CONFLICT,
                    config('response-messages.crud.record_has_childs')
                );
        }

        $blogCategory->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
