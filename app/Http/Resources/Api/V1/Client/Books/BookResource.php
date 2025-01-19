<?php

namespace App\Http\Resources\Api\V1\Client\Books;

use App\Enum\CommentStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = auth(activeGuard())?->user();
        $favorite = $user ? $this->favorites()->where('user_id', $user->id)->exists() : false;

        return [
            'id'                => $this->id,
            'book_name'         => $this->book_name,
            'slug'              => $this->slug,
            'category'          => new BookCategoryResource($this->category),
            'author_name'       => $this->author_name,
            'image'             => $this->image,
            'brief_description' => $this->brief_description,
            'publish_date'      => $this->publish_date,
            'status'            => $this->status,
            'view_count'        => $this->view_count,
            'download_count'    => $this->download_count,
            'is_favorite'       => (bool)$favorite,
            'order_position'    => $this->order_position,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),

           $this->mergeWhen($request->route()->getName() == 'books.show', [
               'book_content'           => $this->book_content,
               'attachments'            => BookAttachmentResource::collection($this->getAttachments()),
               'comments'               => BookCommentResource::collection($this->comments->where('status', CommentStatusEnum::PUBLISHED)),
                'seo'               => [
                    'keywords'   => $this->keywords,
                    'description'=> $this->description
                ],

            ]),


        ];
    }
}
