<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class OperatorLoginController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $operator = Operator::where('email', $request->email)->first();

        if (! $operator || ! Hash::check($request->password, $operator->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Data yang anda masukan salah"
            ), 401);
        }

        $total = $operator->tokens()->count();

        if($total >= 1){
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Akun hanya bisa dalam 1 perangkat !"
            ), 401);

        }

        $token = $operator->createToken('op_token')->plainTextToken;

        $operator->fcm_registration_id = $request->fcm_registration_id;
        $operator->save();

        return response()->json([
                   'access_token' => $token,
                   'token_type' => 'Bearer',
                   'total' => $total
        ]);
    }

    public function logout(Request $request){

        return $request->user()->currentAccessToken()->delete();
    }

}
