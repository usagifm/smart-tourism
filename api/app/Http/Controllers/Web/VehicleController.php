<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleStoreRequest;
use App\Models\RentArea;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
    }

    public function download(Vehicle $vehicle)
    {
        $vehicle->load('vehicleType');

        $pdf = PDF::loadview('vehicles.qrcode', ['vehicle' => $vehicle]);

        return $pdf->download('QR Code ' . $vehicle->serial_number . '.pdf');
    }

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $rentAreas = RentArea::all();

        return view('vehicles.create', compact('vehicleTypes', 'rentAreas'));
    }


    public function store(VehicleStoreRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        QrCode::format('png')
            ->size(800)
            ->margin(5)
            ->generate($vehicle->id, "../public/vehicle/{$vehicle->id}.png");

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
