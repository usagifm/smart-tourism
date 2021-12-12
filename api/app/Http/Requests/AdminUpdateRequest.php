<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique('admins')->ignore($this->admin)],
            'password' => ['nullable', 'confirmed'],
            'password_confirmation' => ['nullable'],
            'name' => ['required'],
            'role' => ['required', 'in:1,2,3']
        ];
    }
}
