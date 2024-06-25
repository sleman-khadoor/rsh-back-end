<?php

namespace App\Http\Resources\Book;

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
            'printing_year' => $this->printing_year,
            'ISBN' => $this->ISBN,
            'EISBN' => $this->EISBN,
            'abstract' => $this->abstract,
            'author' => $this->author?->name
        ];
    }
}
