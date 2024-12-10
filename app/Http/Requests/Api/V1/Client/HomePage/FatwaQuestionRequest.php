<?php

namespace App\Http\Requests\Api\V1\Client\HomePage;

use Illuminate\Foundation\Http\FormRequest;

class FatwaQuestionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name'          => 'required|string|max:190',
            'message'       => 'required|string|max:190',
        ];

    }

    public function attributes(): array
    {
        return [
            'name'        => __('Name'),
            'message'     => __('Message'),
        ];
    }

}
