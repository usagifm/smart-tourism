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


            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyCcFHfVyWdI8H1YG67kyUup7VRq1P_fTOE",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
            ));

            $geolocate =  curl_exec($curl);



            // $geolocate    = Http::post("https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyCcFHfVyWdI8H1YG67kyUup7VRq1P_fTOE");
            // $track = new VehicleTrackHistory;
            // $track->vehicle_id   =  $id;
            // $track->lat     =  $geolocate['location']['lat'];
            // $track->long     =  $geolocate['location']['lng'];
            // $track->save();

        };


        return response($geolocate);

    }


    public function getStatusWithGmaps($id){
        $ongoing = 0;
        $checkIfOngoing = Rental::where("vehicle_id",$id)->where("status", "ongoing")->first();

        if($checkIfOngoing){
            $ongoing = 1;
            $vehicle = Vehicle::find($id);
            $rentArea = RentArea::find($vehicle->rent_area_id);
            $geolocate = Http::post('https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyCcFHfVyWdI8H1YG67kyUup7VRq1P_fTOE');
            $track = new VehicleTrackHistory;
            $track->vehicle_id   =  $id;
            $track->lat     =  $geolocate['location']['lat'];
            $track->long     =  $geolocate['location']['lng'];
            $track->save();
            $response = (new \GoogleMaps\GoogleMaps)->load('directions')
            ->setParam([
                'origin'          => 'place_id:'.$rentArea->origin,
                'destination'     => 'place_id:'.$rentArea->destination,
            ])
           ->isLocationOnEdge($geolocate['location']['lat'], $geolocate['location']['lng'], $rentArea->tolerance);
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
