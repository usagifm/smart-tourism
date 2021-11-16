<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentArea;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class AdminVehicleController extends Controller
{
    // public function getVehiclesByType($id){
    //     $vehicles = Vehicle::where("vehicle_type", $id)->get();

    //     if($vehicles == null){
    //         return response()->json(array(
    //             'message'   =>  "No Data Available "
    //         ), 200);

    //     };

    //     return response()->json(
    //              $vehicles
    //     );

    // }

    public function getVehicles(){
        $vehicles = Vehicle::get();

        if($vehicles == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $vehicles
        );

    }

    public function getVehiclesPosition(Request $request){


    if($request->query('filterByRentAreaId') != null && $request->query('filterByVehicleTypeId') == null){


        $vehicles = Vehicle::where("rent_area_id",$request->query('filterByRentAreaId'))->with('vehiclePosition')->get();


    }


    if($request->query('filterByRentAreaId') == null && $request->query('filterByVehicleTypeId') != null){


        $vehicles = Vehicle::where("vehicle_type_id",  $request->query('filterByVehicleTypeId'))->with('vehiclePosition')->get();


    }


    if($request->query('filterByRentAreaId') != null && $request->query('filterByVehicleTypeId') != null){


        $vehicles = Vehicle::where("vehicle_type_id",$request->query('filterByVehicleTypeId'))->where("rent_area_id", $request->query('filterByRentAreaId'))->with('vehiclePosition')->get();


    }


    if($request->query('filterByRentAreaId') == null && $request->query('filterByVehicleTypeId') == null){


        $vehicles = Vehicle::with('vehiclePosition')->get();


    }

        if($vehicles == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $vehicles
        );

    }

    public function addVehicle(Request $request, $id){

        $request->validate([
            'description'=>['required'],
            'fare'=>'required|min:1|numeric',
            'rent_area_id'=> 'required|min:1|numeric',
        ]);

        $vehicleType = VehicleType::where("id",$id)->first();
        if(!$vehicleType){
            return response()->json(array(
                'message'   =>  "Vehicle Type record not found !"
            ), 483);

        };


        $vehicle = Vehicle::create([
            'vehicle_type_id'=> $id,
            'description'=>$request->description,
            'serial_number'=>$request->serial_number,
            'fare'=>$request->fare,
            'rent_area_id'=>$request->rent_area_id,
            'is_available'=> 1,
            'is_inside'=> true
        ]);

        return response()->json(
                 $vehicle
        );
    }


    public function editVehicle(Request $request, $id, $vehicleTypeId){

        $request->validate([
            'description'=>['required'],
            'fare'=>['required|min:1|numeric'],
            'rent_area_id'=>['required|min:1|numeric'],
        ]);

        $vehicle = Vehicle::where("id",$id)->where("vehicle_type_id",$vehicleTypeId)->first();
        if(!$vehicle){
            return response()->json(array(
                'message'   =>  "Vehicle record not found !"
            ), 483);

        };




        $vehicle->description = $request->description;
        $vehicle->serial_number = $request->serial_number;
        $vehicle->rent_area_id = $request->rent_area_id;
        $vehicle->fare = $request->fare;
        $vehicle->vehicle_type_id = $vehicleTypeId;

        $vehicle->save();

        return response()->json(
                 $vehicle
        );
    }

    public function detailVehicle( $vehicleTypeId, $id){


        $vehicle = Vehicle::where("vehicle_type_id", $vehicleTypeId)->where("id", $id)->first();
        if(!$vehicle){
            return response()->json(array(
                'message'   =>  "Vehicle record not found !"
            ), 483);

        };


        return response()->json(
                 $vehicle
        );
    }



    public function deleteVehicle( $vehicleTypeId, $id){

        $vehicle = Vehicle::where("id", $id)->where("vehicle_type_id", $vehicleTypeId)->first();
        if(!$vehicle){
            return response()->json(array(
                'message'   =>  "Vehicle record not found !"
            ), 483);

        };

        $vehicle->delete();

        return response()->json(array(
                 "message" => "Data deleted !"
        ));
    }

}
