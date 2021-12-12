<?php

namespace App\Http\Controllers\User;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
public function user(Request $request){


    $rentalPaid = Rental::where("user_id" , $request->user()->id)->where("status", "paid")->with(['vehicle', 'invoice'])
    ->get();

    return response()->json(array( $request->user(),
        'total_paid_rental' => $rentalPaid
    ))
    ;


}


}
