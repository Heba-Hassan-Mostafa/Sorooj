<?php

namespace App\Http\Requests\Dashboard\Web\Videos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class VideoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $videoId = $this->route('video')->id ?? null;
        $rules = [
           'name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('videos', 'name')->ignore($videoId)
             ],
            'category_id'           => ['required', 'exists:categories,id', 'integer'],
            'brief_description'     => ['required','string','min:5','max:255'],
            'publish_date'          => ['required', 'date'],
            'youtube_link'          => ['required','url'],
            'keywords'              => ['required','string'],
            'description'           => ['required','string'],

        ];
        if($this->method() == 'PUT'){

            $rules['category_id'] = ['exists:categories,id', 'integer'];

        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name'                 => __('Video Name'),
            'brief_description'    => __('Brief Description'),
            'publish_date'         => __('Publish Date'),
            'keywords'             => __('Keywords'),
            'description'          => __('Description'),
            'category_id'          => __('Category'),
            'status'               => __('Status'),
            'youtube_link'         => __('Youtube Link'),
        ];
    }
}
