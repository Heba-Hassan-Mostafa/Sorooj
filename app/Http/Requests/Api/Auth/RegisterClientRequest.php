<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @bodyParam name string required The user personal name.Example: 0564776688
 * @bodyParam mobile string required The Mobile Number of the user.Example: 0564776688
 * @bodyParam email string (optional) The E-Mail Address of the user.Example: fahmi@moltaqa.net
 * @bodyParam password string required The User bew password.Example: 12345678
 * @bodyParam password_confirmation string required The user new password confirmation.Example: 12345678
 */
class RegisterClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => ["required","string","max:190"],
            "last_name" => ["nullable","string","max:190"],
            "country_code" => ["nullable"],
            "mobile" => ["required","unique:users,mobile"],
            "email" => ["sometimes","unique:users,email"],
            "password" => ["required",Password::default()],
            'device_token' => 'nullable',
            'gender'=>'nullable|in:male,female',
            'language'=>'nullable|in:ar,en',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'mobile' => __('Mobile'),
            'email' => __('E-Mail'),
            'password' => __('Password'),
            'password_confirmation' => __('Password Confirmation'),
        ];
    }
}
