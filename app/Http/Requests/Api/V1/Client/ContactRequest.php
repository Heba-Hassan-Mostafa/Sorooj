<?php

namespace App\Http\Requests\Api\V1\Client;

use App\Enum\ContactTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'mobile' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(ContactTypeEnum::values())],
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
