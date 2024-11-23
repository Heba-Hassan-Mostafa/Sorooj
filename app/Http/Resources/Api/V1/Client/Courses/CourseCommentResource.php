<?php

namespace App\Http\Resources\Api\V1\Client\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseCommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'comment'           => $this->comment,
            'stars'             => $this->stars,
            'course_id'         => $this->commentable_id,
            'status'            => $this->status,
            'created_at'        => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
