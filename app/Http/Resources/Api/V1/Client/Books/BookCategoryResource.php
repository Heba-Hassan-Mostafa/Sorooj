<?php

namespace App\Http\Resources\Api\V1\Client\Books;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'type'          => $this->type,
            'subcategories' => BookCategoryResource::collection($this->subcategory),
            'status'         => $this->status,
            'order_position' => $this->order_position,
            'created_at'    => $this->created_at->format('Y-m-d'),

        ];
    }
}
