<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleTypeStoreRequest;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::all();

        return view('vehicleType.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('vehicleType.create');
    }

    public function store(VehicleTypeStoreRequest $vehicleTypeStoreRequest)
    {
        VehicleType::create($vehicleTypeStoreRequest->validated());

        return redirect()->route('vehicleType.index');
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('vehicleType.edit', compact('vehicleType'));
    }

    public function update(VehicleTypeStoreRequest $vehicleTypeStoreRequest, VehicleType $vehicleType)
    {
        $vehicleType->update($vehicleTypeStoreRequest->validated());

        return redirect()->route('vehicleType.index');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        return redirect()->route('vehicleType.index');
    }
}
