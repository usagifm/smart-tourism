<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique('admins')],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'name' => ['required'],
            'role' => ['required', 'in:1,2,3']
        ];
    }
}
