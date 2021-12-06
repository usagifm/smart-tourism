<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function getUsers(){
        $users = User::get();

        if($users == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $users
        );

    }

    public function getUserDetail($id){
        $user = User::where('id' ,$id)->with(['waiting_rental', 'ongoing_rental','ended_rental', 'paid_rental'])->first();
        if($user == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);
        };
        return response()->json(
                 $user
        );
    }

    public function getUserRentalDetail($id, $rental_id ){
        $rental = Rental::where("user_id", $id)->where("id", $rental_id)->with(['user', 'vehicle','invoice'])
        ->first();

        if($rental == null){
            return response()->json(array(
                'message'   =>  "No Data Available "
            ), 200);

        };

        return response()->json(
                 $rental
        );

    }

}
