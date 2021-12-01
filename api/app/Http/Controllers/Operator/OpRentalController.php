<?php

namespace App\Http\Controllers\Operator;

use Carbon\Carbon;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\invoice;

class OpRentalController extends Controller


{

    public function getAllRental(Request $request){
        $rentalWaiting = Rental::where("status", "waiting")->with(['vehicle', 'user'])
        ->get();

        $rentalOngoing = Rental::where("status", "ongoing")->with(['vehicle', 'invoice','user'])
        ->get();

        $rentalEnded = Rental::where("status", "ended")->with(['vehicle', 'invoice','user'])
        ->get();
        $rentalPaid = Rental::where("status", "paid")->with(['vehicle', 'invoice','user'])
        ->get();


        return response()->json(array(
               "waiting" => $rentalWaiting,
               "ongoing" => $rentalOngoing,
               "ended" => $rentalEnded,
               "paid" => $rentalPaid,
        ));

    }



    public function getRentalDetail($vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->with(['user', 'vehicle'])
        ->first();


        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
            ), 483);

        };

        return response()->json(
                $rental
        );

    }


    public function approveRental(Request $request,$vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "waiting")->with([ 'vehicle'])
        ->first();

        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
            ), 483);

        };

        $isOngoing = Rental::where("status", "ongoing")->where("vehicle_id",$vehicle_id)->first();

        if(!$isOngoing){
            return response()->json(array(
                'message'   =>  "Vehicle is being used !"
            ), 483);

        };


        $now = Carbon::now();


        $rental->operator_id            = $request->user()->id;
        $rental->date_time_start        = $now->toDateTimeString();
        $rental->status                 = "ongoing";
        $rental->save();


        $invoice              = new invoice;
        $invoice->rental_id   =  $rental->id;
        $invoice->user_id     =  $rental->user_id;
        $invoice->is_paid     =  0;
        $invoice->save();



        return response()->json(
        $rental
        );

    }


    public function rejectRental($vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "waiting")
        ->first();

        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
            ), 483);
        };

        if($rental){
        $rental->delete();
        };

        return response()->json(array(
            'message'   =>  "Order deleted !"
        ), 200);

    }


    public function endRental(Request $request,$vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "ongoing")->first();


        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
            ), 483);

        };

        $now = Carbon::now();

        $rental->date_time_end       = $now->toDateTimeString();
        $rental->status              = "ended";
        $rental->save();

        $startTime = $rental->date_time_start;
        $startTime = Carbon::parse($startTime)->timestamp;


        $endTime = $now->timestamp;



        $totalTimeInMinutes = ($endTime - $startTime)/60;

        $vehicle = Vehicle::find($rental->vehicle_id);

        $totalCharge = $totalTimeInMinutes * $vehicle->fare;


        $invoice = invoice::where("user_id",$rental->user_id)->where("rental_id",  $rental->id)->first();
        $invoice->operator_id    = $request->user()->id;
        $invoice->total_charge    =  $totalCharge;
        $invoice->save();



        return response()->json(array(
            'message'   =>  "Rental Ended, ask customer money pls"
        ), 200);

    }


    public function payRental(Request $request,$vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "ended")->first();


        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
            ), 483);

        };


        $rental->status = "paid";
        $rental->save();


        $invoice = invoice::where("user_id",$rental->user_id)->where("rental_id",  $rental->id)->first();
        $invoice->operator_id    = $request->user()->id;
        $invoice->is_paid        =  1;
        $invoice->save();

        return response()->json(array(
            'message'   =>  "Rental has been paid !"
        ), 200);

    }



}
