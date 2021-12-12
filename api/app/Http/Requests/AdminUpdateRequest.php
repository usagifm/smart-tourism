<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AdminUpdateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('manage_admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
