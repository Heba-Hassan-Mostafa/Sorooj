<?php

namespace App\Http\Resources\Api\V1\Client\Videos;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request): array
    {
        $video = getYoutubeId($this->youtube_link);
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'youtube_link'      => $video,
            'category'          => new VideoCategoryResource($this->category),
            'publish_date'      => $this->publish_date,
            'brief_description' => $this->brief_description,
            'keywords'          => $this->keywords,
            'description'       => $this->description,
            'status'            => $this->status,
            'order_position'    => $this->order_position,

        ];
    }
}
