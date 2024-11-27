<?php

namespace App\Http\Resources\Api\V1\Client\Courses;

use App\Enum\CommentStatusEnum;
use App\Models\Course;
use App\Models\Favorite;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CourseResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = auth(activeGuard())?->user();
        $favorite = $this->favorites()->where('user_id', $user?->id)->exists();
        $subscribed = $this->subscriptions()->where('user_id', $user?->id)->exists();

        return [
            'id'                => $this->id,
            'course_name'       => $this->course_name,
            'slug'              => $this->slug,
            'category'          => new CourseCategoryResource($this->category),
            'author_name'       => $this->author_name,
            'image'             => $this->image,
            'course_content'    => $this->course_content,
            'brief_description' => $this->brief_description,
            'publish_date'      => $this->publish_date,
            'status'            => $this->status,
            'view_count'        => $this->view_count,
            'is_favorite'        => (bool)$favorite,
            'is_subscribed'      => (bool)$subscribed,

            'order_position'    => $this->order_position,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),

           $this->mergeWhen($request->route()->getName() == 'courses.courses.show', [
             'videos'                  => CourseVideoResource::collection($this->videos),
              'attachments'            => CourseAttachmentResource::collection($this->getAttachments()),
               'comments'              => CourseCommentResource::collection($this->comments->where('status', CommentStatusEnum::PUBLISHED)),
                'seo'               => [
                    'keywords'   => $this->keywords,
                    'description'=> $this->description
                ],

            ]),


        ];
    }
}
