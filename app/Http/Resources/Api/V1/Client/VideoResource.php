<?php

namespace App\Http\Resources\Api\V1\Client;

use App\Http\Resources\Api\V1\Client\Courses\CourseCategoryResource;
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
            'category'          => new CourseCategoryResource($this->category),
            'publish_date'      => $this->publish_date,
            'keywords'          => $this->keywords,
            'description'       => $this->description,
            'status'            => $this->status,
            'order_position'    => $this->order_position,
            'view_count'        => $this->view_count,

        ];
    }
}
