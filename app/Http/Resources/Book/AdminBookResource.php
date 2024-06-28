<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\BookAward\AdminBookAwardResource;
use App\Http\Resources\BookCategory\AdminBookCategoryResource;
use App\Http\Resources\BookFormat\AdminBookFormatResource;
use App\Http\Resources\BookReview\AdminBookReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->getTranslations(),
            'printing_year' => $this->printing_year,
            'ISBN' => $this->ISBN,
            'EISBN' => $this->EISBN,
            'author' => $this->author?->name,
            'cover_image' => $this->cover_image,
            'book_categories' => AdminBookCategoryResource::collection($this->whenLoaded('bookCategories')),
            'book_awards' => AdminBookAwardResource::collection($this->whenLoaded('awards')),
            'book_formats' => AdminBookFormatResource::collection($this->whenLoaded('formats')),
            'book_reviews' => AdminBookReviewResource::collection($this->whenLoaded('reviews'))
        ];
    }
}
