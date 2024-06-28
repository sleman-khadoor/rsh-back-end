<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\BookAward\PublicBookAwardResource;
use App\Http\Resources\BookCategory\PublicBookCategoryResource;
use App\Http\Resources\BookFormat\PublicBookFormatResource;
use App\Http\Resources\BookReview\PublicBookReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->getTranslations('slug'),
            'printing_year' => $this->printing_year,
            'ISBN' => $this->ISBN,
            'EISBN' => $this->EISBN,
            'abstract' => $this->abstract,
            'author' => $this->author?->name,
            'cover_image' => $this->cover_image,
            'book_categories' => PublicBookCategoryResource::collection($this->whenLoaded('bookCategories')),
            'book_awards' => PublicBookAwardResource::collection($this->whenLoaded('awards')),
            'book_formats' => PublicBookFormatResource::collection($this->whenLoaded('formats')),
            'book_reviews' => PublicBookReviewResource::collection($this->whenLoaded('reviews'))
        ];
    }
}
