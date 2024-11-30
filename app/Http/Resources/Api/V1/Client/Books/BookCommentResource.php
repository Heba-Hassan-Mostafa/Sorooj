<?php

namespace App\Http\Resources\Api\V1\Client\Books;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'comment'           => $this->comment,
            'stars'             => $this->stars,
            'book_id'           => $this->commentable_id,
            'status'            => $this->status,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
