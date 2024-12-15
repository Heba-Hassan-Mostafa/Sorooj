<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                 => $this->id,
            'main_title'         => $this->main_title,
            'event_title'        => $this->event_title,
            'instructor'         => $this->instructor,
            'day'                => $this->event_date?->translatedFormat('l'),
            'event_date'         => $this->event_date?->format('Y-m-d'),
            'time'               => $this->event_date?->format('H:i a'),
            'country_time'       => $this->country_time,
            'location'           => $this->location,
            'image'              => $this->image,
            'is_active'          => $this->is_active
        ];
    }
}
