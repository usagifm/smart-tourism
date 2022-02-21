<?php

namespace App\Http\Controllers\Web\User;

use App\Classes\InvoiceItemExtended;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\VehicleRentRequest;
use App\Models\invoice;
use App\Models\Rental;
use App\Models\Vehicle;
use Carbon\Carbon;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Invoice as InvoicesPdf;

class VehicleController extends Controller
{
    public function create()
    {
        $onGoingVehicles = Rental::query()
            ->where(function ($query) {
                $query->where('status', 'ended')
                    ->orWhere('status', 'ongoing')
                    ->orWhere('status', 'waiting');
            })
            ->get()
            ->pluck('vehicle_id')
            ->toArray();

        $vehicles = Vehicle::query()
            ->whereNotIn('id', $onGoingVehicles)
            ->where('is_available', '1')
            ->get()
            ->pluck('serial_number', 'id')
            ->prepend('Pilih Kendaraan', '');

        $rentals = Rental::query()
            ->with(['user', 'vehicle', 'invoice'])
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('status', 'waiting')
                    ->orWhere('status', 'ended')
                    ->orWhere('status', 'ongoing');
            })
            ->get();

        $rentals->transform(function ($item) {
            $item->price = 0;
            $item->total_time = 0;

            if ($item->status == 'ongoing') {
                $item->total_time = Carbon::parse($item->date_time_start)->diffInMinutes(now()->setTimezone('Asia/Jakarta')->toDateTimeString());
                $item->price = ceil($item->total_time / 30) * $item->vehicle->fare;
            } else if ($item->status == 'ended') {
                $item->total_time = Carbon::parse($item->date_time_start)->diffInMinutes($item->date_time_end);
                $item->price = ceil($item->total_time / 30) * $item->vehicle->fare;
            }

            return $item;
        });

        $countVehicle = Rental::where('user_id', auth()->id())
            ->get();

        $countVehicle = [
            'waiting' => $countVehicle->where('status', 'waiting')->count(),
            'ongoing' => $countVehicle->where('status', 'ongoing')->count(),
            'ended' => $countVehicle->where('status', 'ended')->count(),
            'paid' => $countVehicle->where('status', 'paid')->count()
        ];

        return view('user.dashboard', compact('vehicles', 'rentals', 'countVehicle'));
    }

    public function store(VehicleRentRequest $vehicleRentRequest)
    {
        Rental::create($vehicleRentRequest->validated() + [
            'user_id' => auth()->id(),
            'status' => 'waiting'
        ]);

        return redirect()->route('dashboard');
    }

    public function history()
    {
        $invoices = invoice::query()
            ->with(['rental.vehicle'])
            ->where('user_id', auth()->id())
            ->get();

        return view('user.history', compact('invoices'));
    }

    public function invoices(invoice $invoice)
    {
        abort_if(auth()->id() != $invoice->user_id, 403, 'This invoice is not belong to you.');

        $invoice->load(['rental.vehicle.rentArea', 'rental.vehicle.vehicleType']);

        $customer = new Buyer([
            'name'          => auth()->user()->name,
            'custom_fields' => [
                'email' => auth()->user()->email,
                'No HP' => auth()->user()->phone,
            ],
        ]);

        $item = (new InvoiceItemExtended())
            ->title($invoice->rental->vehicle->serial_number)
            ->quantity($invoice->rental->vehicle->fare)
            ->pricePerUnit($invoice->total_charge)
            ->totalTime($invoice->rental->date_time_start, $invoice->rental->date_time_end)
            ->rentArea($invoice->rental->vehicle->rentArea->name)
            ->vehicleType($invoice->rental->vehicle->vehicleType->type)
            ->logoMenujuTubaba(public_path('images/tubaba.png'))
            ->logoDikominfoTubaba(public_path('images/kominfo_tubaba.png'))
            ->logoDishub(public_path('images/dishub.png'))
            ->logoItera(public_path('images/itera.png'));

        $invoice = InvoicesPdf::make()
            ->dateFormat('d-m-Y')
            ->name('Invoice')
            ->buyer($customer)
            ->addItem($item)
            ->logo(public_path('images/logo_tubaba.png'))
            ->filename('Invoice');

        return $invoice->stream();
    }
}
