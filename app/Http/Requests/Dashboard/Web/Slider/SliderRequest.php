<?php

namespace App\Http\Requests\Dashboard\Web\Slider;

use App\Models\Category;
use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SliderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sliderId = $this->route('slider')->id ?? null;
        $rules = [
            'title' => [
                'sometimes', 'string', 'min:3', 'max:255',
                Rule::unique('sliders', 'title')->ignore($sliderId)
            ],
            'link'                  => ['sometimes', 'nullable', 'url'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
        ];
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'title'                 => __('Title'),
            'link'                  => __('Link'),
            'image'                 => __('Courses Image'),
            'status'                => __('Status'),
        ];
    }
}
