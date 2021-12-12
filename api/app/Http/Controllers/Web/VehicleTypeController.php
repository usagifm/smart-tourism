<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleTypeStoreRequest;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class VehicleTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_type_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleTypes = VehicleType::all();

        return view('vehicleType.index', compact('vehicleTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('manage_type_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('vehicleType.create');
    }

    public function store(VehicleTypeStoreRequest $vehicleTypeStoreRequest)
    {
        VehicleType::create($vehicleTypeStoreRequest->validated());

        return redirect()->route('vehicleType.index');
    }

    public function edit(VehicleType $vehicleType)
    {
        abort_if(Gate::denies('manage_type_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('vehicleType.edit', compact('vehicleType'));
    }

    public function update(VehicleTypeStoreRequest $vehicleTypeStoreRequest, VehicleType $vehicleType)
    {
        $vehicleType->update($vehicleTypeStoreRequest->validated());

        return redirect()->route('vehicleType.index');
    }

    public function destroy(VehicleType $vehicleType)
    {
        abort_if(Gate::denies('manage_type_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicleType->delete();

        return redirect()->route('vehicleType.index');
    }
}
