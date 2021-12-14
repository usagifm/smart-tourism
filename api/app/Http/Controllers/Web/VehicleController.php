<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleStoreRequest;
use App\Models\RentArea;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Symfony\Component\HttpFoundation\Response;


class VehicleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
    }

    public function download(Vehicle $vehicle)
    {
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle->load('vehicleType');

        $pdf = PDF::loadview('vehicles.qrcode', ['vehicle' => $vehicle]);

        if (!file_exists(public_path("vehicle/{$vehicle->id}.png"))) {
            QrCode::format('png')
                ->size(800)
                ->margin(5)
                ->generate($vehicle->id, public_path("vehicle/{$vehicle->id}.png"));
        }

        return $pdf->download('QR Code ' . $vehicle->serial_number . '.pdf');
    }

    public function create()
    {
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            ->generate($vehicle->id, public_path("vehicle/{$vehicle->id}.png"));

        return redirect()->route('vehicles.index');
    }

    public function edit(Vehicle $vehicle)
    {
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
        abort_if(Gate::denies('manage_vehicle'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vehicle->delete();

        return redirect()->route('vehicles.index');
    }
}
