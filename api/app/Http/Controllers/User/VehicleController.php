<?php

namespace App\Http\Controllers\User;

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


        return response()->json(array(
            'message'   =>  "Pesanan berhasil, silahkan minta operator untuk di terima"
        ), 200);

    }


    public function getVehicleTypeAvailable($id){

        $vehicleType = VehicleType::where("id", $id)->first()->with(['vehicle']);


        if(!$vehicleType){
            return response()->json(array(
                'message'   =>  "Data Kendaraan tidak ditemukan!"
            ), 483);

        };

        return response()->json(
                $vehicleType
        );

    }





}
