<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class MostViewedResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'author_name'       => $this->author_name,
            'brief_description' => $this->brief_description,
            'publish_date'      => $this->publish_date,
            'view_count'        => $this->view_count,
            'image'             => $this->image,
            'type'              => $this->type,
            'trans_type'        => __($this->type),
        ];
    }
}
