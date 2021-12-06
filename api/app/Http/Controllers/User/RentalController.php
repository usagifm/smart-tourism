<?php

namespace App\Http\Controllers\User;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleTrackHistory;

class RentalController extends Controller
{

    public function getRentalDetail($vehicle_id, $id, Request $request){
        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("user_id",$request->user()->id)->with(['vehicle', 'invoice'])
        ->first();
        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
            ), 483);

        };
        $location = null;
        if($rental->status == "ongoing"){
            $location = VehicleTrackHistory::where("vehicle_id", $rental->vehicle_id)->latest()->first();
        };
        return response()->json(array(
                $rental,
                $location
        ));

    }


    public function getAllRental(Request $request){
        $rentalWaiting = Rental::where("user_id" , $request->user()->id)->where("status", "waiting")->with(['vehicle'])
        ->get();

        $rentalOngoing = Rental::where("user_id" , $request->user()->id)->where("status", "ongoing")->with(['vehicle', 'invoice'])
        ->get();

        $rentalEnded = Rental::where("user_id" , $request->user()->id)->where("status", "ended")->with(['vehicle', 'invoice'])
        ->get();


        return response()->json(array(
               "waiting" => $rentalWaiting,
               "ongoing" => $rentalOngoing,
               "ended" => $rentalEnded,

        ));

    }



}
