<?php

namespace App\Http\Controllers\Web;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
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



        return view('dashboard.index', compact('vehicles'));
    }
}
