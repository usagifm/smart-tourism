<?php

namespace App\Http\Controllers\User;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
public function user(Request $request){


    $rentalPaid = Rental::where("user_id" , $request->user()->id)->where("status", "paid")->get();

    return response()->json(array(
        'user' => $request->user(),
        'total_paid_rental' => $rentalPaid
    ))
    ;


}


}
