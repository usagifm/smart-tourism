<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentArea extends Model
{
    use HasFactory;

    protected function serializeDate(\DateTimeInterface $date)
{
    return $date->format('c');
}


    protected $fillable = [
        'name',
        'operational_hour',
        'origin',
        'destination',
        'tolerance'
    ];


}
