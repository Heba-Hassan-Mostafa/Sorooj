<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class FatwaQuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'user'    => [
                'id'   => $this->user?->id,
                'name' => $this->user?->first_name,
                'email' => $this->user?->email
            ],
            'message' => $this->message,
            'status'  => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
