<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ability'
    ];

    public function users()
    {
        return $this->belongsToMany(Admin::class);
    }
}
