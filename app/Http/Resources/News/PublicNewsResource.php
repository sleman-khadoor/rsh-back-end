<?php

namespace App\Http\Resources\News;

use App\Http\Resources\Book\PublicBookResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicNewsResource extends JsonResource
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
            'content' => $this->content,
            'cover_image' => $this->cover_image,
            'slug' => $this->getTranslations('slug'),
        ];
    }
}
