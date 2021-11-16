<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentArea;
use App\Models\User;
use Illuminate\Http\Request;

class AdminRentAreaController extends Controller
{
    public function getRentAreas(){
        $rentAreas = RentArea::get();

        if($rentAreas == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $rentAreas
        );

    }

    public function addRentArea(Request $request){

        $request->validate([
            'name'=>['required'],
            'origin'=>['required'],
            'destination'=>['required'],
            'tolerance'=>  'required|min:1|numeric',
        ]);

        $rentArea = RentArea::create([
            'name'=> $request->name,
            'origin'=>$request->origin,
            'destination'=>$request->destination,
            'tolerance'=>  $request->tolerance,
        ]);

        return response()->json(
                 $rentArea
        );
    }


    public function editRentArea(Request $request, $id){

        $request->validate([
            'name'=>['required'],
            'origin'=>['required'],
            'destination'=>['required'],
            'tolerance'=>  'required|min:1|numeric',
        ]);

        $rentArea = RentArea::find($id);
        if(!$rentArea){
            return response()->json(array(
                'message'   =>  "Rent Area  record not found !"
            ), 483);

        };


        $rentArea->name = $request->name;
        $rentArea->origin = $request->origin;
        $rentArea->destination = $request->destination;
        $rentArea->tolerance = $request->tolerance;
        $rentArea->save();

        return response()->json(
                 $rentArea
        );
    }

    public function detailRentArea( $id){

        $rentArea = RentArea::find($id);
        if(!$rentArea){
            return response()->json(array(
                'message'   =>  "Rent Area  record not found !"
            ), 483);

        };


        return response()->json(
                 $rentArea
        );
    }



    public function deleteRentArea($id){

        $rentArea = RentArea::find($id);
        if(!$rentArea){
            return response()->json(array(
                'message'   =>  "Rent Area record not found !"
            ), 483);

        };


        $rentArea->delete();

        return response()->json(array(
                 "message" => "Data deleted !"
        ));
    }

}
