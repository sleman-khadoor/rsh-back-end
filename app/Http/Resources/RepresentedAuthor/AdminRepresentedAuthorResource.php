<?php

namespace App\Http\Resources\RepresentedAuthor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRepresentedAuthorResource extends JsonResource
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
            ...$this->getTranslations(),
            'avatar' => $this->avatar,
        ];
    }
}
