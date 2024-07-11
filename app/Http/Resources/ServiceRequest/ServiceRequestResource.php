<?php

namespace App\Http\Resources\ServiceRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'fullname' => $this->fullname,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'description' => $this->description,
            'service_name' => $this->service_name,
            'date' => $this->date,
            'slug' => $this->slug,
            'documents' => ServiceRequestDocumentResource::collection($this->whenLoaded('documents'))
        ];
    }
}
