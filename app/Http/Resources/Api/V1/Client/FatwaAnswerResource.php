<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class FatwaAnswerResource extends JsonResource
{
    public function toArray($request): array
    {
        $video = getYoutubeId($this->youtube_link);
        return [
            'id'                => $this->id,
            'fatwa_question'    => [
                 'id'      => $this->fatwa_question_id,
                 'slug'     => $this->fatwaQuestion?->slug,
                 'question' => $this->fatwaQuestion?->message,
                 'name'    => $this->fatwaQuestion?->name,
            ],
            'answer_content'    => $this->answer_content,
            'audio_file'        => $this->getFirstMediaUrl('audio_file'),
            'youtube_link'      => $video ?? '',
            'publish_date'      => $this->publish_date,
        ];
    }
}
