<?php

namespace App\Http\Resources\Api\V1\Client\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'type'           => $this->type,
            'status'         => $this->status,
            'order_position' => $this->order_position,
            'blogs_count'    => $this->blogs->count(),
            'created_at'     => $this->created_at->format('Y-m-d'),

        ];
    }
}
