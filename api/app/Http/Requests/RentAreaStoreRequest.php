<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentAreaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'operational_hour' => ['required'],
            'origin' => ['required'],
            'destination' => ['required'],
            'tolerance' => ['required', 'integer']
        ];
    }
}
