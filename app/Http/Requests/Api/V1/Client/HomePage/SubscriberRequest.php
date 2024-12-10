<?php

namespace App\Http\Requests\Api\V1\Client\HomePage;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'email' => ['required', 'email', 'unique:subscribers', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
        ];

    }

    public function attributes(): array
    {
        return [
            'email'        => __('E-mail'),
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => 'The email format is invalid',
        ];
    }

}
