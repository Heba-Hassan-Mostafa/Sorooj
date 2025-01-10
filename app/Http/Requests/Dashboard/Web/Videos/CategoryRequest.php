<?php

namespace App\Http\Requests\Dashboard\Web\Videos;

use App\Enum\CategoryTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
          //  'name'       => ['required', 'string', 'min:3' ,'max:255','unique:categories,name,'.$categoryId],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('type', CategoryTypeEnum::VIDEO)
                    ->ignore($categoryId)
            ],
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
