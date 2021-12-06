<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Models\RentArea;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
    }


    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $rentAreas = RentArea::all();

        return view('vehicles.create', compact('vehicleTypes', 'rentAreas'));
    }


    public function store(VehicleStoreRequest $request)
    {
        Vehicle::create($request->validated());

        return redirect()->route('vehicles.index');
    }

    public function edit(Vehicle $vehicle)
    {
        $vehicleTypes = VehicleType::all();
        $rentAreas = RentArea::all();

        return view('vehicles.edit', compact('vehicle', 'vehicleTypes', 'rentAreas'));
    }

    public function update(VehicleStoreRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return redirect()->route('vehicles.index');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index');
    }
}
