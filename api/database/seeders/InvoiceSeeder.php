<?php

namespace Database\Seeders;

use App\Models\invoice;
use App\Models\Operator;
use App\Models\Rental;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
        Operator::factory()->count(10)->create();
        Rental::factory()->count(10)->create();
        Vehicle::factory()->count(10)->create();

        invoice::factory()->count(100)->create();
    }
}
