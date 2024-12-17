<?php

namespace App\Http\Requests\Dashboard\Web\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BlogRequest extends FormRequest
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
            'blog_content'          => ['sometimes','nullable'],
            'brief_description'     => ['required','string','min:5','max:255'],
            'author_name'           => ['required', 'string','min:5','max:255'],
            'publish_date'          => ['required', 'date'],
            'keywords'              => ['required','string'],
            'description'           => ['required','string'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
            'video_name'            => 'nullable|string|max:255',
            'youtube_link'          => 'nullable|url',
            'attachments.*'         => 'nullable|mimes:pdf|max:64000',

        ];
        if($this->method() == 'PUT'){

            $rules['category_id'] = ['exists:categories,id', 'integer'];

        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'blog_name'            => __('Blog Name'),
            'blog_content'         => __('Blog Content'),
            'brief_description'    => __('Brief Description'),
            'author_name'          => __('Author Name'),
            'publish_date'         => __('Publish Date'),
            'keywords'             => __('Keywords'),
            'description'          => __('Description'),
            'image'                => __('Blog Image'),
            'category_id'          => __('Category'),
            'status'               => __('Status'),
            'video_name'           => __('Video Name'),
            'youtube_link'         => __('Youtube Link'),
            'attachments.*'        => __('Attachments'),
        ];
    }
}
