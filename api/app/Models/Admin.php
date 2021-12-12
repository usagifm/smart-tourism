<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_SUPERADMIN = 1;
    const ROLE_DISPORA = 2;
    const ROLE_DISHUB = 3;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
