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
    return $date->format('Y-m-d H:i:s');
}

    protected $fillable = [
        'type',
        'description',
    ];
}
