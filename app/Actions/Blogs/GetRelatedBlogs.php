<?php

namespace App\Actions\Blogs;

use App\Models\Blog;
use App\Http\Resources\Blog\PublicBlogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetRelatedBlogs {

    public function execute(Blog $blog): AnonymousResourceCollection {

        $numberOfBlogsInDB = Blog::count();
        $numberOfRequiredRelatedBlogs = config('core-config.number_of_related_blogs');

        $relatedBlogsCount = $numberOfRequiredRelatedBlogs <= $numberOfBlogsInDB ? $numberOfRequiredRelatedBlogs : $numberOfBlogsInDB;

        $blogCategoryIDS = $blog->blogCategories()->pluck('blog_category_id')->toArray();


        $relatedBlogs = Blog::with('blogCategories')
                            ->where('id', '!=', $blog->id)
                            ->where('lang', $blog->lang)
                            ->whereHas('blogCategories', function($query) use ($blogCategoryIDS) {
                                    $query->whereIn('blog_categories.id', $blogCategoryIDS);
                            })
                            ->orderBy('date', 'DESC')
                            ->take($relatedBlogsCount)
                            ->get();

        return PublicBlogResource::collection($relatedBlogs);
    }
}
