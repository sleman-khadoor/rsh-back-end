<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\BlogCategory\PublicBlogCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicBlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'writer' => $this->writer,
            'date' => $this->date,
            'lang' => $this->lang,
            'cover_image' => $this->cover_image,
            'blog_categories' => PublicBlogCategoryResource::collection($this->whenLoaded('blogCategories')),
            'blog_categories' => array_map(function($category) {
                return [
                    'title' => $category['title'][$this->lang],
                    'slug' => $category['slug'][$this->lang],
                ];
            }, $this->blogCategories->toArray())
        ];
    }
}
