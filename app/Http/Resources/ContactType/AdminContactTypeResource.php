<?php

namespace App\Http\Resources\ContactType;

use App\Http\Resources\Contact\AdminContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminContactTypeResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'contacts' => AdminContactResource::collection($this->whenLoaded('contacts'))
        ];
    }
}
