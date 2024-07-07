<?php

namespace App\Http\Resources\ContactType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicContactTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title
        ];
    }
}
