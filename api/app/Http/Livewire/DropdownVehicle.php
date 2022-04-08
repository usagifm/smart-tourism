<?php

namespace App\Http\Livewire;

use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Livewire\Component;

class DropdownVehicle extends Component
{
    public $type = '';
    public $vehicle;

    public $types;
    public $vehicles;

    public function mount()
    {
        $this->types = VehicleType::all();
        $this->vehicles = collect();
    }

    public function render()
    {
        return view('livewire.dropdown-vehicle');
    }

    public function updatedType($value)
    {
        $this->vehicles = Vehicle::where('vehicle_type_id', $value)->get();
    }

    public function store()
    {
        $this->validate(['vehicle' => ['required']]);

        Rental::create([
            'vehicle_id' => $this->vehicle,
            'user_id' => auth()->id(),
            'status' => 'waiting'
        ]);

        $this->reset();
        $this->vehicles = collect();

        return redirect()->route('dashboard');
    }
}
