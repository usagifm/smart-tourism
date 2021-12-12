<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class VehicleTypeStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('manage_type_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'type' => ['required'],
            'description' => ['required']
        ];
    }
}
