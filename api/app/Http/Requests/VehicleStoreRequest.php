<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
