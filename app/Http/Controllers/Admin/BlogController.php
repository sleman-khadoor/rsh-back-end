<?php

namespace App\Http\Controllers\Admin;

use App\Filters\FilterBlogByCategory;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\Blog\AdminBlogResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Blog;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('Blog Management', 'APIs for managing Blogs')]
class BlogController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->setResource(AdminBlogResource::class);
    }

    #[Endpoint('Get all Blogs.')]
    #[QueryParam('filter[title]', 'string', 'filter Blogs by name.', false)]
    #[QueryParam('filter[writer]', 'string', 'filter Blogs by writer name.', false)]
    #[QueryParam('include[]', 'array', 'relations to load on the blog', false, example: "['blogCategories']")]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {
        $blogs = QueryBuilder::for(Blog::class)
                            ->allowedIncludes(Blog::allowedIncludes())
                            ->allowedFilters([
                                ...Blog::allowedFilters(),
                                AllowedFilter::custom('blog_category', new FilterBlogByCategory),
                            ])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($blogs);
    }

    #[Endpoint('Get Blog by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Blog', true)]
    public function show(Blog $blog) {

        return $this->resource($blog->load(Blog::allowedIncludes()));
    }

    #[Endpoint('Store Blog.')]
    #[BodyParam('title', 'string', 'The title of the Blog.')]
    #[BodyParam('content', 'string', 'The content of the Blog.')]
    #[BodyParam('writer', 'string', 'The writer of the Blog.')]
    #[BodyParam('date', 'date', 'The date of the Blog.')]
    #[BodyParam('lang', 'enum', 'The lang of the Blog.')]
    #[BodyParam('cover_image', 'file', 'The cover image of the Blog.')]
    #[BodyParam('categories', 'array', 'The categories of the Blog.')]
    #[BodyParam('categories.*.id', 'int', 'The id of the category.')]
    public function store(StoreBlogRequest $request) {

        $data = $request->validated();

        $blog = Blog::create($data);

        if($request->hasFile('cover_image')) {
            $blog->cover_image = $this->uploadAttachment($data['cover_image'], 'blog-covers');
            $blog->save();
        }

        if($data['categories']) {
            $blog->blogCategories()->attach(Arr::flatten($data['categories']));
        }

        return $this->resource($blog, method:'POST');
    }

    #[Endpoint('Update Blog.')]
    #[BodyParam('title', 'string', 'The title of the Blog.')]
    #[BodyParam('content', 'string', 'The content of the Blog.')]
    #[BodyParam('writer', 'string', 'The writer of the Blog.')]
    #[BodyParam('date', 'date', 'The date of the Blog.')]
    #[BodyParam('lang', 'enum', 'The lang of the Blog.')]
    #[BodyParam('cover_image', 'file', 'The cover image of the Blog.')]
    #[BodyParam('categories', 'array', 'The categories of the Blog.')]
    #[BodyParam('categories.*.id', 'int', 'The id of the category.')]
    public function update(UpdateBlogRequest $request, Blog $blog) {

        $data = $request->validated();

        $blog->update($data);

        if($request->hasFile('cover_image')) {
            $blog->cover_image = $this->uploadAttachment($data['cover_image'], 'blog-covers');
            $blog->save();
        }

        if($request->categories) {
            $blog->blogCategories()->sync(Arr::flatten($data['categories']));
        }

        return $this->resource($blog, method:'PUT');
    }

    #[Endpoint('Delete Blog.')]
    #[UrlParam('slug', 'string', 'The slug of the Blog', true)]
    public function destroy(Blog $blog) {
        $blog->blogCategories()->detach();
        $blog->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
