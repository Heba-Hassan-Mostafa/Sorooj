<?php

namespace App\Http\Requests\Dashboard\Web;

use Illuminate\Foundation\Http\FormRequest;


class ManagementMemberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('management_member')?->id;

        $rules = [
            'name'         => ['string', 'min:3','max:255'],
            'position'     => [ 'string','min:3' ,'max:255'],
            'avatar'       => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];
        if ($this->method() == 'POST') {
            $rules['name']     = ['required','string', 'min:3','max:255'];
            $rules['position'] = ['required','string','min:3' ,'max:255'];
            $rules['avatar']   = ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name'            => __('Name'),
            'position'        => __('Position'),
            'avatar'          => __('Avatar'),
        ];
    }
}
