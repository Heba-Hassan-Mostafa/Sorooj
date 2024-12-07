<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image,
            'status' => $this->status,
            'order_position' => $this->order_position,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
