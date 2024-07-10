<?php

namespace App\Http\Resources\ContactRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fullname' => $this->fullname,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'message' => $this->message,
            'date' => $this->date,
            'slug' => $this->slug
        ];
    }
}
