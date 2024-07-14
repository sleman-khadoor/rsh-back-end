<?php

namespace App\Http\Controllers\Main;

use App\Actions\Blogs\GetRelatedBlogs;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\FilterBlogByCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\Blog\PublicBlogResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Public Endpoints')]
#[Subgroup('Blogs', 'APIs for Blogs')]
class BlogController extends Controller
{

    #[Endpoint('Get all Blogs.')]
    #[QueryParam('filter[title]', 'string', 'filter Blogs by name.', false)]
    #[QueryParam('filter[writer]', 'string', 'filter Blogs by writer name.', false)]
    #[QueryParam('filter[category_id]', 'string', 'filter Blogs by category.', false)]
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

        return PublicBlogResource::collection($blogs);
    }

    #[Endpoint('Get Blog by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Blog', true)]
    public function show(Blog $blog, GetRelatedBlogs $getRelatedBlogsAction) {

        return PublicBlogResource::make($blog->load(Blog::allowedIncludes()))->additional([
            'related_blogs' => $getRelatedBlogsAction->execute($blog)
        ]);
    }
}
