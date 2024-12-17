<?php

namespace App\Http\Requests\Dashboard\Web\Blogs;

use Illuminate\Foundation\Http\FormRequest;


class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')->id ?? null;
        $rules = [
            'name'       => ['required', 'string', 'min:3' ,'max:255','unique:categories,name,'.$categoryId],
            'parent_id'  => ['nullable', 'exists:categories,id']
            ];

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'status' => __('Status'),
        ];
    }
}
