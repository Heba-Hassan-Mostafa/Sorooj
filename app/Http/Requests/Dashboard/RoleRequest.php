<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Role;
use App\Rules\RoleBodyRule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [];
        $roleId = $this->route('role');


        foreach (app_languages() as $key => $one) {
            $rules["name_{$key}"] = [
                'required', 'min:1', 'max:250',
                function ($attribute, $value, $fail) use ($key, $roleId) {
                    $existingRole = Role::where("name->{$key}", $value)
                        ->where('guard_name', 'web');

                    // Exclude the current role from the uniqueness check
                    if ($roleId) {
                        $existingRole->where('id', '!=', $roleId);
                    }

                    $existingRole = $existingRole->first();

                    if ($existingRole) {
                        $fail(__('The role name for :lang already exists.', ['lang' => $key]));
                    }
                },
            ];
        }

        // Add any other rules you need
        $rules['role_permissions'] = [new RoleBodyRule()];

        return $rules;
    }

}
