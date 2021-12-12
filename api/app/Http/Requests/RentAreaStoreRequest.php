<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RentAreaStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('manage_rent_area'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
