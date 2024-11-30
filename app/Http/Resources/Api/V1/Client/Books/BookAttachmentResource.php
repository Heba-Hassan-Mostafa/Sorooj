<?php

namespace App\Http\Resources\Api\V1\Client\Books;

use Illuminate\Http\Resources\Json\JsonResource;

class BookAttachmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->file_name,
            'url'  => $this->getFullUrl(),
        ];
    }
}
