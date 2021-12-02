<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;


    public function user() {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id')->with(['vehiclePosition']);
    }

    public function invoice() {
        return $this->hasOne(invoice::class, 'rental_id')->withDefault();
    }

    public function vehiclePosition() {
        return $this->hasOne(VehicleTrackHistory::class, 'vehicle_id')->latest('created_at');
    }

}
