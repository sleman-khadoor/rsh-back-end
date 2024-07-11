<?php

namespace App\Http\Resources\Partner;

use App\Http\Resources\BlogCategory\AdminBlogCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminPartnerResource extends JsonResource
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
            'website_link' => $this->website_link,
        ];
    }
}
