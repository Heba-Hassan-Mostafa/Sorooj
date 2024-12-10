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
            'fatwa_question_id' => $this->fatwa_question_id,
            'answer_content'    => $this->answer_content,
            'audio_file'        => $this->audio_file,
            'youtube_link'      => $video,
            'publish_date'      => $this->publish_date,
        ];
    }
}
