<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Models\VehicleTrackHistory;
use App\Http\Controllers\Controller;

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



        if($rental->status == 'ongoing'){
            $now = Carbon::now()->timestamp;
            $startTime = $rental->date_time_start;
            $startTime = Carbon::parse($startTime)->timestamp;

            $duration = Floor(($now - $startTime)/60);

            return response()->json(array(
                'rental'=> $rental,
                'duration' => $duration,
                'location' => $location
            ));

        }
        return response()->json(array(
            'rental'=> $rental,
            'location' => $location
        ));

    }


    public function getAllRental(Request $request){
        $rentalWaiting = Rental::where("user_id" , $request->user()->id)->where("status", "waiting")->with(['vehicle'])
        ->get();

        $rentalOngoing = Rental::where("user_id" , $request->user()->id)->where("status", "ongoing")->with(['vehicle', 'invoice'])
        ->get();

        $rentalEnded = Rental::where("user_id" , $request->user()->id)->where("status", "ended")->with(['vehicle', 'invoice'])
        ->get();
        $rentalPaid = Rental::where("user_id" , $request->user()->id)->where("status", "paid")->with(['vehicle', 'invoice'])
        ->get();

        // $totalPaidRental = Rental::where("user_id", $request->user()->id)->where("status", "paid")->count();


        return response()->json(array(
            //   "total_paid_rental" => count($rentalPaid),
               "waiting" => $rentalWaiting,
               "ongoing" => $rentalOngoing,
               "ended" => $rentalEnded,
               "paid" => $rentalPaid

        ));

    }



}
