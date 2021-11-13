<?php

namespace App\Models;

use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded= ['id'];

    public function vehicleType() {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id')->withDefault();
    }
    public function rentArea() {
        return $this->belongsTo(RentArea::class, 'rent_area_id')->withDefault();
    }

    public function ongoingRental() {
        return $this->hasMany(Rental::class, 'vehicle_id')->where("status", "ongoing" );
    }
}

