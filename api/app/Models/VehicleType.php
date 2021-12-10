<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    public function vehicle() {
        return $this->hasMany(Vehicle::class, 'vehicle_type_id');
    }

    protected function serializeDate(\DateTimeInterface $date)
{
    return $date->format('M d Y');
}

    protected $fillable = [
        'type',
        'description',
    ];
}
