<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagementMemberResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'position'          => $this->position,
            'is_active'         => $this->is_active,
            'order_position'    => $this->order_position,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
