<?php

namespace App\Http\Requests\Dashboard\Web\Courses;

use App\Models\Category;
use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CourseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->route('course')->id ?? null;
        $rules = [
           'course_name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('courses', 'course_name')->ignore($courseId)
             ],
            'category_id'           => ['required', 'exists:categories,id', 'integer'],
            'course_content'        => ['sometimes','nullable'],
            'brief_description'     => ['required','string','min:5','max:255'],
            'author_name'           => ['required', 'string','min:5','max:255'],
            'publish_date'          => ['required', 'date'],
            'keywords'              => ['required','string'],
            'description'           => ['required','string'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
            'status'                =>['boolean','in:0,1'],
            'videos.*.name'         => 'nullable|string|max:255',
            'videos.*.youtube_link' => 'nullable|url',
            'attachments.*'         => 'nullable|mimes:pdf|max:64000',
            'exam_link'             => 'nullable|url',

        ];
        if($this->method() == 'PUT'){

            $rules['category_id'] = ['exists:categories,id', 'integer'];

        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'course_name'          => __('Courses Name'),
            'course_content'       => __('Courses Content'),
            'brief_description'    => __('Brief Description'),
            'author_name'          => __('Author Name'),
            'publish_date'         => __('Publish Date'),
            'keywords'             => __('Keywords'),
            'description'          => __('Description'),
            'image'                => __('Courses Image'),
            'category_id'          => __('Category'),
            'videos.*.name'         => __('Video Name'),
            'videos.*.youtube_link' => __('Youtube Link'),
            'status'                => __('Status'),
            'attachments.*'         => __('Attachments'),
        ];
    }
}
