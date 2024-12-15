<?php

namespace App\Http\Resources\Api\V1\Client\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogVideoResource extends JsonResource
{
    public function toArray($request): array
    {
        $video = getYoutubeId($this->youtube_link);
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'video_url'         => $video,
            'blog_id'         => $this->videoable_id,
            'publish_date'      => $this->publish_date,
        ];
    }
}
