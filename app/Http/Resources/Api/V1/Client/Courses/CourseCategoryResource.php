<?php

namespace App\Http\Resources\Api\V1\Client\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'subcategories' => CourseCategoryResource::collection($this->subcategory),
            'status' => $this->status,
            'order_position' => $this->order_position,
            'courses_count' => $this->courses->count(),
            'created_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
