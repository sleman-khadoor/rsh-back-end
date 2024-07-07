<?php

namespace App\Http\Resources\Contact;

use App\Http\Resources\ContactType\PublicContactTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->value,
            'contact_type' => PublicContactTypeResource::make($this->whenLoaded('contactType'))
        ];
    }
}
