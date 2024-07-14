<?php

namespace App\Actions\Blogs;

use App\Models\Blog;
use App\Http\Resources\Blog\PublicBlogResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection as SupportCollection;

class GetRelatedBlogs {

    public function execute(Blog $blog): Collection {

        $numberOfBlogsInDB = Blog::where('lang', $blog->lang)->count();
        $numberOfRequiredRelatedBlogs = config('core-config.number_of_related_blogs');

        $relatedBlogsCount = $numberOfRequiredRelatedBlogs <= $numberOfBlogsInDB ? $numberOfRequiredRelatedBlogs : $numberOfBlogsInDB;

        $blogCategoryIDS = $blog->blogCategories()->pluck('blog_category_id');


        $relatedBlogs = $this->getListOfRelatedBlogs($blog->id, $blog->lang, $blogCategoryIDS, $relatedBlogsCount);

        $missingBlogsCount = $relatedBlogsCount - $relatedBlogs->count();

        if ($missingBlogsCount > 0) {

            $randomBlogs = $this->getListOfRandomBlogs($blog->id, $blog->lang, $relatedBlogs, $missingBlogsCount);

            $relatedBlogs = $relatedBlogs->concat($randomBlogs);
        }


        return $relatedBlogs;
    }

    private function getListOfRelatedBlogs(
        int $blogId,
        string $blogLang,
        SupportCollection $blogCategoryIDS,
        int $relatedBlogsCount
    ): Collection {

        return Blog::where('id', '!=', $blogId)
                    ->where('lang', $blogLang)
                    ->whereHas('blogCategories', function($query) use ($blogCategoryIDS) {
                            $query->whereIn('blog_categories.id', $blogCategoryIDS);
                    })
                    ->with('blogCategories')
                    ->orderBy('date', 'DESC')
                    ->take($relatedBlogsCount)
                    ->get();
    }

    private function getListOfRandomBlogs(
        int $blogId,
        string $blogLang,
        Collection $relatedBlogs,
        int $missingBlogsCount
    ): Collection {

        return Blog::where('id', '!=', $blogId)
                    ->where('lang', $blogLang)
                    ->whereNotIn('id', $relatedBlogs->pluck('id'))
                    ->with('blogCategories')
                    ->inRandomOrder()
                    ->take($missingBlogsCount)
                    ->get();
    }
}
