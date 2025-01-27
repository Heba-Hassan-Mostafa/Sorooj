<?php

namespace App\Http\Resources\Api\V1\Client\Videos;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'type'           => $this->type,
            'status'         => $this->status,
            'order_position' => $this->order_position,
            'videos_count'   => $this->videos->count(),
            'created_at'     => $this->created_at->format('Y-m-d'),

        ];
    }
}
