<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class VehicleStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'vehicle_type_id' => ['required', Rule::exists('vehicle_types', 'id')],
            'label' => ['required'],
            'serial_number' => ['required'],
            'fare' => ['required', 'integer'],
            'description' => ['required'],
            'brand' => ['required'],
            'is_available' => ['required', 'in:1,2'],
            'is_inside' => ['required', 'in:1,2'],
            'rent_area_id' => ['required', Rule::exists('rent_areas', 'id')]
        ];
    }
}
