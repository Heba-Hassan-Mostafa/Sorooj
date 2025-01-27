<?php

namespace App\Http\Requests\Dashboard\Web\Blogs;

use App\Models\Category;
use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateBlogRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogId = $this->route('blog')->id ?? null;
        $rules = [
            'blog_name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('blogs', 'blog_name')->ignore($blogId)
            ],
            'category_id'           => ['required', 'exists:categories,id', 'integer'],
            'blog_content'        => ['sometimes','nullable'],
            'brief_description'     => ['required','string','min:5','max:255'],
            'author_name'           => ['required', 'string','min:5','max:255'],
            'publish_date'          => ['required', 'date'],
            'keywords'              => ['required','string'],
            'description'           => ['required','string'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
            'status'                =>['boolean','in:0,1'],
            'attachments.*'         => 'nullable|mimes:pdf|max:64000',
            'exam_link'             => 'nullable|url',
            // Videos validation
            'videos'                    => 'nullable|array',
            'videos.*.id'               => 'nullable|exists:videos,id',
            'videos.*.name'             => 'nullable|string|max:255',
            'videos.*.youtube_link'     => 'nullable|url|max:255',

            // New video entries
            'videos.new'                => 'nullable|array',
            'videos.new.*.name'         => 'sometimes|string|max:255',
            'videos.new.*.youtube_link' => 'sometimes|url|max:255',
            'audio_file'               => ['nullable','file','mimes:mp3'],

        ];

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'blog_name'            => __('Blogs Name'),
            'blog_content'         => __('Blogs Content'),
            'brief_description'    => __('Brief Description'),
            'author_name'          => __('Author Name'),
            'publish_date'         => __('Publish Date'),
            'keywords'             => __('Keywords'),
            'description'          => __('Description'),
            'image'                => __('Blogs Image'),
            'category_id'          => __('Category'),
            'videos.*.name'         => __('Video Name'),
            'videos.*.youtube_link' => __('Youtube Link'),
            'status'                => __('Status'),
            'attachments.*'         => __('Attachments'),
            'audio_file'           => __('Audio File'),
        ];
    }
}
