<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class AdminVehicleTypeController extends Controller
{
    public function getVehicleTypes(){
        $vehicleTypes = VehicleType::get();

        if($vehicleTypes == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $vehicleTypes
        );

    }

    public function addVehicleType(Request $request){

        $request->validate([
            'description'=>['required'],
            'type'=>['required'],
        ]);

        $vehicleType = VehicleType::create([
            'description'=> $request->description,
            'type'=>$request->type,
        ]);

        return response()->json(
                 $vehicleType
        );
    }


    public function editVehicleType(Request $request, $id){

        $request->validate([
            'description'=>['required'],
            'type'=>['required'],
        ]);

        $vehicleType = VehicleType::find($id);
        if(!$vehicleType){
            return response()->json(array(
                'message'   =>  "Vehicle Type record not found !"
            ), 483);

        };


        $vehicleType->description = $request->description;
        $vehicleType->type = $request->type;
        $vehicleType->save();

        return response()->json(
                 $vehicleType
        );
    }

    public function detailVehicleType($id){

        $vehicleType = VehicleType::where("id",$id)->with(['vehicle'])->first();
        if(!$vehicleType){
            return response()->json(array(
                'message'   =>  "Vehicle Type record not found !"
            ), 483);

        };


        return response()->json(
                 $vehicleType
        );
    }



    public function deleteVehicleType($id){

        $vehicleType = VehicleType::find($id);
        if(!$vehicleType){
            return response()->json(array(
                'message'   =>  "Vehicle Type record not found !"
            ), 483);

        };

        $vehicleType->delete();

        return response()->json(array(
                 "message" => "Data deleted !"
        ));
    }

}
