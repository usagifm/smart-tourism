<?php

namespace App\Http\Controllers\Operator;

use Carbon\Carbon;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\invoice;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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


        if($rental->status == "ended" || $rental->status == "paid")

        return response()->json(
                $rental
        );

    }


    public function approveRental(Request $request,$vehicle_id, $id){


        $isOngoing = Rental::where("vehicle_id",$vehicle_id)->where("status", "ongoing")->first();

        if($isOngoing){
            return response()->json(array(
                'message'   =>  "Vehicle is being used !"
            ), 483);

        };


        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "waiting")->with([ 'vehicle'])
        ->first();

        if(!$rental){
            return response()->json(array(
                'message'   =>  "Rental record not found !"
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

        $user = User::find($rental->user_id);


        // Http::withHeaders([
        //     'Authorization' => 'key='+env('FCM_SERVER_KEY'),
        // ])->post('https://fcm.googleapis.com/fcm/send', [
        //     'registration_ids' => [$user->fcm_registration_id],
        //     'notification' => `{
        //         title : Hore ! Pesanan sewa kendaraan anda di setujui !,
        //         body : Kami ingatkan bahwa jangan menggunakan kendaraan sewa diluar area peminjaman ya dan tetap berhati hati dalam berkendara
        //      }`
        // ]);



        $curl = curl_init();
        $authKey = "key="+ env('FCM_SERVER_KEY');
        $registration_ids = [$user->fcm_registration_id];
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{
                        "registration_ids": ' . $registration_ids . ',
                        "notification": {
                            "title": "Hore ! Pesanan sewa kendaraan anda di setujui !",
                            "body": "Kami ingatkan bahwa jangan menggunakan kendaraan sewa diluar area peminjaman ya dan tetap berhati hati dalam berkendara"
                        }
                    }',
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $authKey,
            "Content-Type: application/json",
            "cache-control: no-cache"
        ),
        ));

        curl_exec($curl);


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
