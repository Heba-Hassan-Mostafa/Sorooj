<?php

namespace App\Http\Resources\Api\V1\Client\Blogs;

use App\Enum\CommentStatusEnum;
use App\Models\Course;
use App\Models\Favorite;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = auth(activeGuard())?->user();
        $favorite = $user ? $this->favorites()->where('user_id', $user->id)->exists() : false;

        $sortedVideos = $this->videos->sortByDesc('order_position');

        return [
            'id'                => $this->id,
            'blog_name'       => $this->blog_name,
            'slug'              => $this->slug,
            'category'          => new BlogCategoryResource($this->category),
            'author_name'       => $this->author_name,
            'image'             => $this->image,
            'blog_content'    => $this->blog_content,
            'brief_description' => $this->brief_description,
            'publish_date'      => $this->publish_date,
            'status'            => $this->status,
            'view_count'        => $this->view_count,
            'download_count'     => $this->download_count,
            'is_favorite'        => (bool)$favorite,

            'order_position'    => $this->order_position,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),

           $this->mergeWhen($request->route()->getName() == 'blogs.blogs.show', [
              'videos'                  => BlogVideoResource::collection($this->videos),
               'attachments'            => BlogAttachmentResource::collection($this->getAttachments()),
               'comments'               => BlogCommentResource::collection($this->comments->where('status', CommentStatusEnum::PUBLISHED)),
                'seo'               => [
                    'keywords'   => $this->keywords,
                    'description'=> $this->description
                ],

            ]),


        ];
    }
}
