<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\Rental;
use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;
use App\Models\VehicleTrackHistory;
use App\Http\Controllers\Controller;

class VehicleRentalController extends Controller
{

    public function getStatus($id){
        $ongoing = false;
        $checkIfOngoing = Rental::where("vehicle_id",$id)->where("status", "ongoing")->first();

        if($checkIfOngoing){
            $ongoing = true;
        };

        return response()->json(array(
                "ongoing" => $ongoing,
        ));

    }


    public function getStatusWithGmaps($id){
        $ongoing = false;
        $checkIfOngoing = Rental::where("vehicle_id",$id)->where("status", "ongoing")->first();

        if($checkIfOngoing){
            $ongoing = true;
        };

        $response = (new \GoogleMaps\GoogleMaps)->load('directions')
        ->setParam([
            'origin'          => 'place_id:ChIJu9xDDV3FQC4RUyVsXFijGR8',
            'destination'     => 'place_id:ChIJcdsEK6zEQC4RSUoTGNyoLRE',
        ])
       ->isLocationOnEdge(-5.360273551463675, 105.31016811262346, 500);

        return response()->json(array(
                "ongoing" => $ongoing,
                "diluar_batas" => $response,
        ));

    }

    public function sendTrackHistory($id, Request $request){

        $track = new VehicleTrackHistory;
        $track->vehicle_id   =  $request->id;
        $track->lat     =  $request->lat;
        $track->long     =  $request->long;
        $track->save();
        return response()->json(array(
                "message" => "Data saved ! ",
        ));

    }

    public function googleMaps(){

    $response = (new \GoogleMaps\GoogleMaps)->load('directions')
            ->setParam([
                'origin'          => 'place_id:ChIJu9xDDV3FQC4RUyVsXFijGR8',
                'destination'     => 'place_id:ChIJcdsEK6zEQC4RSUoTGNyoLRE',
            ])
           ->isLocationOnEdge(-5.360273551463675, 105.31016811262346, 500);


    return response()->json(array(
                "is_inside" =>  $response,
        ));

            }

}
