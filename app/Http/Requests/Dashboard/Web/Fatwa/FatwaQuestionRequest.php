<?php

namespace App\Http\Requests\Dashboard\Web\Fatwa;

use App\Models\Category;
use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class FatwaQuestionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'answer_content'        => ['sometimes','nullable', 'string'],
            'youtube_link'          => ['sometimes', 'nullable', 'url'],
            'audio_file'            =>['nullable','file','mimes:mp3,wav,ogg,webm,mp4,3gp,flv,mkv,avi,mpg,wmv,asf,ts,aac,3gpp,amr,amr-wb,mp4a,webm,3g2,asf,flv,ts'],
            'publish_date'          => ['required','date'],
        ];
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'answer_content'               => __('Answer'),
            'youtube_link'                 => __('Youtube Link'),
            'audio_file'                   => __('Audio File'),
            'publish_date'                 => __('Publish Date'),
        ];
    }
}
