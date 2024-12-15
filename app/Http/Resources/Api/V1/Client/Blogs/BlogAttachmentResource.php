<?php

namespace App\Http\Resources\Api\V1\Client\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogAttachmentResource extends JsonResource
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
