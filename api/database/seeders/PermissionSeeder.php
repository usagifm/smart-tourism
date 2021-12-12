<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'name' => 'Kelola Kendaraan',
                'ability' => 'manage_vehicle',
            ],
            [
                'name' => 'Kelola Tipe Kendaraan',
                'ability' => 'manage_type_vehicle'
            ],
            [
                'name' => 'Kelola Area Penyewaan',
                'ability' => 'manage_rent_area'
            ],
            [
                'name' => 'Kelola Customer',
                'ability' => 'manage_customer'
            ],
            [
                'name' => 'Kelola Operator',
                'ability' => 'manage_operator'
            ],
            [
                'name' => 'Kelola Admin',
                'ability' => 'manage_admin'
            ],
            [
                'name' => 'Lihat Statistik Penyewaan Kendaraan',
                'ability' => 'show_statistic_rent_vehicle'
            ],
            [
                'name' => 'Kelola Hak Akses',
                'ability' => 'manage_permission'
            ],
            [
                'name' => 'Lihat Statistik Pendapatan',
                'ability' => 'show_statistic_revenue'
            ],
            [
                'name' => 'Kelola User',
                'ability' => 'manage_user'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $permission = Permission::all();
        Admin::findOrFail(1)->permissions()->sync($permission->pluck('id'));
    }
}
