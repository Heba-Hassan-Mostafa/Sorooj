<?php

namespace App\Http\Resources\Api\V1\Client\Audios;

use Illuminate\Http\Resources\Json\JsonResource;

class AudioResource extends JsonResource
{
    public function toArray($request): array
    {
        $video = getYoutubeId($this->youtube_link);
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'youtube_link'      => $video,
            'audio_file'        => $this->getFirstMediaUrl('audio_file'),
            'category'          => new AudioCategoryResource($this->category),
            'publish_date'      => $this->publish_date,
            'brief_description' => $this->brief_description,
            'view_count'        => $this->view_count,
            'keywords'          => $this->keywords,
            'description'       => $this->description,
            'status'            => $this->status,
            'order_position'    => $this->order_position,

        ];
    }
}
