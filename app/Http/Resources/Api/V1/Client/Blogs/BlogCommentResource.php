<?php

namespace App\Http\Resources\Api\V1\Client\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'comment'           => $this->comment,
            'stars'             => $this->stars,
            'blog_id'           => $this->commentable_id,
            'status'            => $this->status,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
