<?php

namespace App\Http\Requests\Dashboard\Web;

use App\Rules\UniqueWithoutSoftDeleted;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;


class AdminRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;  // Proceed with validation if the user is a admin
    }

    public function rules(): array
    {
        $adminId = $this->route('admin')?->id;

        $rules = [
            'mobile'       => [new UniqueWithoutSoftDeleted('users', 'mobile', $adminId)],
            'email'        => [new UniqueWithoutSoftDeleted('users', 'email', $adminId)],
            'first_name'   => ['string', 'max:255'],
            'last_name'    => ['nullable', 'string', 'max:255'],
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (Route::currentRouteName() != 'profile.update') {
            $rules['roles'] = 'exists:roles,id|required';
            if ($this->method() == 'POST') {
                $rules['first_name'] = ['required', 'string', 'max:255'];
                $rules['last_name'] = ['nullable', 'string', 'max:255'];
                $rules['password'] = 'required|confirmed';
                $rules['mobile'] = ['required', new UniqueWithoutSoftDeleted('users', 'mobile')];
                $rules['email'] = ['required', new UniqueWithoutSoftDeleted('users', 'email')];
            }
        }

        return $rules;
    }


    public function failedAuthorization()
    {
        abort(403, __('User is not a admin'));
    }

    public function attributes(): array
    {
        return [
            'first_name'      => __('First Name'),
            'last_name'       => __('Last Name'),
            'mobile'          => __('Mobile'),
            'email'           => __('Email'),
            'password'        => __('Password'),
            'password_confirmation' => __('Confirm Password'),
            'avatar'          => __('Avatar'),
            'roles'           => __('Roles'),
        ];
    }
}
