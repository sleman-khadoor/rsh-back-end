<?php

namespace App\Http\Resources\RepresentedAuthor;

use App\Http\Resources\Book\PublicBookResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicRepresentedAuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'about' => $this->about,
            'avatar' => $this->avatar,
            'slug' => $this->getTranslations('slug'),
        ];
    }
}
