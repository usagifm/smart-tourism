<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'operator_id',
        'date_time_start',
        'date_time_end',
        'status'
    ];

    protected $casts = [
        'date_time_start' => 'datetime',
        'date_time_end' => 'datetime'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id')->with(['vehiclePosition']);
    }

    public function invoice()
    {
        return $this->hasOne(invoice::class, 'rental_id');
    }

    public function vehiclePosition()
    {
        return $this->hasOne(VehicleTrackHistory::class, 'vehicle_id')->latest('created_at');
    }
}
