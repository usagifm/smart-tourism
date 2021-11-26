<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\RentArea;
use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;
use App\Models\VehicleTrackHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class VehicleRentalController extends Controller
{

    public function getStatus($id){
        $ongoing = 0;
        $checkIfOngoing = Rental::where("vehicle_id",$id)->where("status", "ongoing")->first();

        if($checkIfOngoing){
            $ongoing = 1;

            $geoDB = Http::get('https://geolocation-db.com/json')->json();

            $track = new VehicleTrackHistory;
            $track->vehicle_id   =  $id;
            $track->lat     =  $geoDB['latitude'];
            $track->long     =  $geoDB['longitude'];
            $track->save();

        };


        return response()->json($ongoing);

    }


    public function getStatusWithGmaps($id){
        $ongoing = 0;
        $checkIfOngoing = Rental::where("vehicle_id",$id)->where("status", "ongoing")->first();

        if($checkIfOngoing){
            $ongoing = 1;

            $vehicle = Vehicle::find($id);

            $rentArea = RentArea::find($vehicle->rent_area_id);

            $geoDB = Http::get('https://geolocation-db.com/json');

            $track = new VehicleTrackHistory;
            $track->vehicle_id   =  $id;
            $track->lat     =  $geoDB['latitude'];
            $track->long     =  $geoDB['longitude'];
            $track->save();

            $response = (new \GoogleMaps\GoogleMaps)->load('directions')
            ->setParam([
                'origin'          => 'place_id:'.$rentArea->origin,
                'destination'     => 'place_id:'.$rentArea->destination,
            ])
           ->isLocationOnEdge($geoDB->latitude, $geoDB['latitude'], $geoDB['longitude']);

           if($response == false ){
            $ongoing = 2;

           }
        };

        return response()->json($ongoing);

    }

    // akses ke geodb

    public function sendTrackHistory($id, Request $request){

        $track = new VehicleTrackHistory;
        $track->vehicle_id   =  $id;
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
