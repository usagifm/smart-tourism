<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id' => ['required']
        ];
    }
}
