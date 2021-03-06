<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'operator_id',
        'rental_id',
        'is_paid',
        'total_charge'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
