<?php

namespace App\Http\Requests\Dashboard\Web\HomeSections;

use App\Models\Category;
use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class EventRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventId = $this->route('upcoming_event')->id ?? null;
        $rules = [
            'main_title'            => ['required','string', 'min:3', 'max:255'],
            'event_title'           => ['required','string', 'min:3', 'max:255'],
            'instructor'            => ['required','string', 'min:3', 'max:255'],
            'event_date_date'       => ['required','date','after:today','date_format:Y-m-d'],
            'event_date_time'       => ['required','date_format:H:i'],
            'country_time'          => ['required','string', 'min:3', 'max:255'],
            'location'              => ['required','string', 'min:3', 'max:255'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
        ];
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'main_title'                 => __('dashboard.events.main-title'),
            'event_title'                => __('dashboard.events.event-title'),
            'instructor'                 => __('dashboard.events.instructor'),
            'event_date_date'            => __('dashboard.events.event-date'),
            'event_date_time'            => __('dashboard.events.event-time'),
            'country_time'               => __('dashboard.events.country-time'),
            'location'                   => __('dashboard.events.location'),
            'image'                      => __('Image'),
        ];
    }
}
