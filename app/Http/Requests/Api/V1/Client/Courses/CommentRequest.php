<?php

namespace App\Http\Requests\Api\V1\Client\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name'          => 'required|string|max:190',
            'comment'       => 'required|string',
            'stars'         => 'required|integer',
        ];

    }

    public function attributes(): array
    {
        return [
            'name'        => __('Name'),
            'comment'     => __('Comment'),
            'stars'       => __('Stars'),
        ];
    }

}
