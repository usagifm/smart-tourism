<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    public function waiting_rental() {
        return $this->hasMany(Rental::class, 'user_id')->where("status", "waiting");
    }

    public function ongoing_rental() {
        return $this->hasMany(Rental::class, 'user_id')->where("status", "ongoing");
    }


    public function ended_rental() {
        return $this->hasMany(Rental::class, 'user_id')->where("status", "ended");
    }

    public function paid_rental() {
        return $this->hasMany(Rental::class, 'user_id')->where("status", "paid");
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
