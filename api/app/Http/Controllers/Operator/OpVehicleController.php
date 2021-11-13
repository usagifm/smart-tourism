<?php

namespace App\Http\Controllers\Operator;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OpVehicleController extends Controller
{



    public function getVehicles(){

        $vehicles = Vehicle::with(['vehicleType'])
        ->get();


        if($vehicles == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $vehicles
        );

    }

    public function getVehicleDetail($id){

        $vehicle = Vehicle::where("id", $id)->with(['vehicleType', 'rentArea','ongoingRental'])
        ->first();


        if(!$vehicle){
            return response()->json(array(
                'message'   =>  "Vehicle record not found !"
            ), 483);

        };

        return response()->json(
                $vehicle
        );

    }

}
