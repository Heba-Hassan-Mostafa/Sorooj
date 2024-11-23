<?php

namespace App\Http\Resources\Api\V1\Client\Courses;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseVideoResource extends JsonResource
{
    public function toArray($request): array
    {
        $video = getYoutubeId($this->youtube_link);
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'video_url'         => $video,
            'course_id'         => $this->videoable_id,
            'publish_date'      => $this->publish_date,
        ];
    }
}
