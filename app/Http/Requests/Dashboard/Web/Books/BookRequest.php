<?php

namespace App\Http\Requests\Dashboard\Web\Books;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BookRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->id ?? null;
        $rules = [
           'book_name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('books', 'book_name')->ignore($bookId)
             ],
            'category_id'           => ['required', 'exists:categories,id', 'integer'],
            'book_content'          => ['sometimes','nullable'],
            'brief_description'     => ['required','string','min:5','max:255'],
            'author_name'           => ['required', 'string','min:5','max:255'],
            'publish_date'          => ['required', 'date'],
            'keywords'              => ['required','string'],
            'description'           => ['required','string'],
            'image'                 =>['nullable','image','mimes:png,jpg,jpeg,gif,webp,svg','max:2048'],
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
            'book_name'            => __('Book Name'),
            'book_content'         => __('Book Content'),
            'brief_description'    => __('Brief Description'),
            'author_name'          => __('Author Name'),
            'publish_date'         => __('Publish Date'),
            'keywords'             => __('Keywords'),
            'description'          => __('Description'),
            'image'                => __('Book Image'),
            'category_id'          => __('Category'),
            'status'                => __('Status'),
            'attachments.*'         => __('Attachments'),
        ];
    }
}
