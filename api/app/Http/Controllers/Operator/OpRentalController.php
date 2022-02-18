<?php

namespace App\Http\Controllers\Operator;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Rental;
use App\Models\invoice;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class OpRentalController extends Controller


{

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    public function getAllRental(Request $request){
        $rentalWaiting = Rental::where("status", "waiting")->with(['vehicle', 'user'])
        ->get();

        $rentalOngoing = Rental::where("status", "ongoing")->with(['vehicle', 'invoice','user'])
        ->get();

        $rentalEnded = Rental::where("status", "ended")->with(['vehicle', 'invoice','user'])
        ->get();
        $rentalPaid = Rental::where("status", "paid")->whereDate("created_at", Carbon::today())->with(['vehicle', 'invoice','user'])
        ->get();


        return response()->json(array(
               "waiting" => $rentalWaiting,
               "ongoing" => $rentalOngoing,
               "ended" => $rentalEnded,
               "paid" => $rentalPaid,
        ));

    }



    public function getRentalDetail($vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->with(['user', 'vehicle','invoice'])
        ->first();



        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
            ), 483);

        };

        $min = null;
        $sec = null;
        $duration = null;
        $now = null;

        if($rental->status == 'ongoing'){
            $now = Carbon::now()->timestamp;
            $startTime = $rental->date_time_start;
            $startTime = Carbon::parse($startTime)->timestamp;
            $vehicle = Vehicle::where("id", $vehicle_id)->first();
            $duration = Floor(($now - $startTime)/60);
            $cost = ceil(($now - $startTime)/1800);

            return response()->json(array(
                'duration' => $duration,
                'rental'=> $rental,
                'cost'=> $cost*$vehicle->fare
            ));

        }

        if($rental->status == 'paid' || $rental->status == 'ended'){
            $endTime = $rental->date_time_end;
            $endTime = Carbon::parse($endTime)->timestamp;
            $startTime = $rental->date_time_start;
            $startTime = Carbon::parse($startTime)->timestamp;

            $duration = Floor(($endTime - $startTime)/60);

            return response()->json(array(
                'duration' => $duration,
                'rental'=> $rental,
            ));

        }


        return response()->json(array(
            'rental'=> $rental
        ));
    }


    public function approveRental(Request $request,$vehicle_id, $id){


        $isOngoing = Rental::where("vehicle_id",$vehicle_id)->where("status", "ongoing")->first();

        if($isOngoing){
            return response()->json(array(
                'message'   =>  "Kendaraan sedang digunakan !"
            ), 483);

        };


        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "waiting")->with([ 'vehicle'])
        ->first();

        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
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

        $tokens = User::whereNotNull("fcm_registration_id")->where('id', $rental->user_id)->get()->pluck('fcm_registration_id')->toArray();

        if ($tokens != null){
            $data = [
                "registration_ids" => $tokens,
                "notification" => [
                    "title" => "Hore ! Pesanan sewa kendaraan anda di setujui !",
                    "body" => "Kami ingatkan bahwa jangan menggunakan kendaraan sewa diluar area peminjaman ya dan tetap berhati hati dalam berkendara"],
                "data" => [
                        "rental_id" => $rental->id,
                        "vehicle_id" => $rental->vehicle_id,
                ]
            ];

            $encodedData = json_encode($data);

            $this->sendNotification($encodedData);
        }

        return response()->json(
        $rental
        );

    }


    public function rejectRental($vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "waiting")
        ->first();

        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
            ), 483);
        };

        if($rental){
        $rental->delete();
        };

        return response()->json(array(
            'message'   =>  "Pesanan dihapus !"
        ), 200);

    }


    public function endRental(Request $request,$vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "ongoing")->first();


        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
            ), 483);

        };

        $now = Carbon::now();

        $rental->date_time_end       = $now->toDateTimeString();
        $rental->status              = "ended";
        $rental->save();

        $startTime = $rental->date_time_start;
        $startTime = Carbon::parse($startTime)->timestamp;


        $endTime = $now->timestamp;



        $totalTimeIn30Minutes = ceil(($endTime - $startTime)/1800);

        $vehicle = Vehicle::find($rental->vehicle_id);

        $totalCharge = $totalTimeIn30Minutes * $vehicle->fare;


        $invoice = invoice::where("user_id",$rental->user_id)->where("rental_id",  $rental->id)->first();
        $invoice->operator_id    = $request->user()->id;
        $invoice->total_charge    =  $totalCharge;
        $invoice->save();

        $tokens = User::whereNotNull("fcm_registration_id")->where('id', $rental->user_id)->first();

        if ($tokens != null){
            $data = [
                "registration_ids" => $tokens->fcm_registration_id,
                "notification" => [
                    "title" => "Sewa anda telah diakhiri !",
                    "body" => `Silahkan lakukan pembayaran kepada operator ya`,
                                 ],
           "data" => [
                    "rental_id" => $rental->id,
                    "vehicle_id" => $rental->vehicle_id,
                ]
            ];

            $encodedData = json_encode($data);

            $this->sendNotification($encodedData);
        }


        return response()->json(array(
            'message'   =>  "Rental telah usai, silahkan menagih pengguna kendaraan"
        ), 200);

    }


    public function payRental(Request $request,$vehicle_id, $id){

        $rental = Rental::where("id", $id)->where("vehicle_id",$vehicle_id)->where("status", "ended")->first();


        if(!$rental){
            return response()->json(array(
                'message'   =>  "Data rental tidak ditemukan!"
            ), 483);

        };


        $rental->status = "paid";
        $rental->save();


        $invoice = invoice::where("user_id",$rental->user_id)->where("rental_id",  $rental->id)->first();
        $invoice->operator_id    = $request->user()->id;
        $invoice->is_paid        =  1;
        $invoice->save();

        $tokens = User::whereNotNull("fcm_registration_id")->where('id', $rental->user_id)->first();

        if ($tokens != null){
            $data = [
                "registration_ids" => $tokens->fcm_registration_id,
                "notification" => [
                    "title" => "Sewa telah dibayar !",
                    "body" => `Terimakasih ya {$tokens->name}, kami tunggu penyewaan anda yang selanjutnya.`,
                                 ],
               "data" => [
                    "rental_id" => $rental->id,
                    "vehicle_id" => $rental->vehicle_id,
                ]
            ];

            $encodedData = json_encode($data);

            $this->sendNotification($encodedData);
        }


        return response()->json(array(
            'message'   =>  "Rental telah dibayar!"
        ), 200);

    }



}
