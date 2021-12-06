<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Vehicle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
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
                return view('home', [
                    "data" => "tidak ada ",
                ]);
            };

            // return response()->json(
                return view('home', [
                    "data" => $vehicles,
                ]);
            // );

        // return view('home', [
        //     "data" => $data,
        // ]);
    }
}
