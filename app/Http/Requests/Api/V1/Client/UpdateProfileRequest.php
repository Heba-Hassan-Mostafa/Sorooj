<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            //'mobile' => 'nullable|unique:users,mobile,' . auth()->id().'|min_digits:8|max_digits:15',
            "country_code"   => ['nullable',"unique:users,mobile"],
            'mobile'         => ['nullable','unique:users,mobile,' . auth()->id(),'min:8','max:15',],
            'email'          => 'nullable|unique:users,email,' . auth()->id() . '|email',
            'first_name'     => 'nullable|string|max:190',
            'last_name'      => 'nullable|string|max:190',
            'avatar'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'       => 'nullable|confirmed|string',
        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'mobile' => __('Mobile'),
            'country_code' => __('Country Code'),
            'email' => __('E-Mail'),
            'password' => __('Password'),
            'password_confirmation' => __('Password Confirmation'),
        ];
    }

}
