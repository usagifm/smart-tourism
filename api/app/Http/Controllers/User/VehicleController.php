<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Rental;
use App\Models\invoice;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function getVehicles(){

        $vehicles = Vehicle::with(['vehicleType'])
        ->get();


        if($vehicles == null){
            return response()->json(array(
                'message'   =>  "Data Kendaraan tidak ditemukan!"
            ), 200);

        };

        return response()->json(
                 $vehicles
        );

    }


    public function getVehicleDetail($id){

        $vehicle = Vehicle::where("id", $id)->with(['vehicleType', 'rentArea'])
        ->first();


        if(!$vehicle){
            return response()->json(array(
                'message'   =>  "Data Kendaraan tidak ditemukan!"
            ), 483);

        };

        return response()->json(
                $vehicle
        );

    }


    public function rentVehicle(Request $request, $id){

        $vehicle = Vehicle::find($id);

        if(!$vehicle)
        return response()->json(array(
            'message'   =>  "Data Kendaraan tidak ditemukan!"
        ), 483);


        if($vehicle->is_available != 1)
        return response()->json(array(
            'message'   =>  "Data Kendaraan tidak tersedia!"
        ), 483);


        $alreadyOrder = Rental::where("vehicle_id", $id)->where("status", "waiting")->where("user_id", $request->user()->id)->first();

        if($alreadyOrder)
        return response()->json(array(
            'message'   =>  "Anda telah memesan kendaraan ini !"
        ), 483);


        $rentalOngoing = Rental::where("vehicle_id", $id)->where("status", "ongoing")->first();

        if($rentalOngoing)
        return response()->json(array(
            'message'   =>  "Kendaraan sedang digunakan !"
        ), 483);


        $rental              = new Rental;
        $rental->vehicle_id  = $id;
        $rental->user_id     =  $request->user()->id;
        $rental->status = "waiting";
        $rental->save();

        $tokens = User::whereNotNull("fcm_registration_id")->where('id', $rental->user_id)->get()->pluck('fcm_registration_id')->toArray();

        if ($tokens != null){
            $data = [
                "registration_ids" => $tokens,
                "notification" => [
                    "title" => "Anda berhasil memesan penyewaan !",
                    "body" => "Silahkan hubungi operator kami untuk meminta persetujuan penyewaan ya"],
                "data" => [
                    "rental" => $rental
                ]
            ];

            $encodedData = json_encode($data);
            $this->sendNotification($encodedData);
        }

        $tokenOperator = User::whereNotNull("fcm_registration_id")->get()->pluck('fcm_registration_id')->toArray();


        if ($tokenOperator != null){
            $data = [
                "registration_ids" => $tokenOperator,
                "notification" => [
                    "title" => "Pesanan baru telah di terima !",
                    "body" => "Silahkan konfirmasi kepada pengguna untuk persetujuan penyewaannya ya."],
                "data" => [
                    "rental" => $rental
                ]
            ];

            $encodedData = json_encode($data);
            $this->sendNotification($encodedData);
        }



        return response()->json(array(
            'message'   =>  "Pesanan berhasil, silahkan minta operator untuk di terima"
        ), 200);

    }


    public function getVehicleTypeAvailable($id){
        $vehicleTypeDetail = VehicleType::where('id', $id)->first();

        if(!$vehicleTypeDetail)
        return response()->json(array(
            'message'   =>  "Data tipe kendaraan tidak ditemukan !"
        ), 483);


        $totalVehicleByVehicleTypeId = Vehicle::where('vehicle_type_id', $id)->get()->count();

        $vehiclesUsedeByVehicleTypesId = Vehicle::join('rentals', 'vehicles.id', '=', 'rentals.vehicle_id')
        ->where("vehicle_type_id", $id)->where('rentals.status', '=', 'ongoing')->get()->count();

        $available = $totalVehicleByVehicleTypeId - $vehiclesUsedeByVehicleTypesId;

        // if(!$vehiclesAvailableByVehicleTypesId){
        //     return response()->json(array(
        //         'message'   =>  "Data Kendaraan tidak ditemukan!"
        //     ), 483);
        // };

        return response()->json(array(
                'detail' => $vehicleTypeDetail,
                'total_vehicle' => $totalVehicleByVehicleTypeId,
                'available_vehicle'=> $available,
        )

    );

}





}
