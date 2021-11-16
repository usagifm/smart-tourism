<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionInRentAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rent_areas', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('origin');
            $table->string('destination');
            $table->integer('tolerance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_areas', function (Blueprint $table) {
            //
        });
    }
}
