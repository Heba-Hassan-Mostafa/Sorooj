<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'email'             => $this->email,
        ];
    }
}
