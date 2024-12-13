<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'mobile'             => $this->phone,
            'message'           => $this->message,
            'status'            => $this->status,
            'type'              => $this->type,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
