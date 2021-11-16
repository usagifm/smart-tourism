<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class AdminLoginController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "The provided credentials are incorrect."
            ), 401);
        }

        // $total = $operator->tokens()->count();

        // if($total >= 1){
        //     return response()->json(array(
        //         'code'      =>  401,
        //         'message'   =>  "Can only login in one device! "
        //     ), 401);

        // }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
                   'access_token' => $token,
                   'token_type' => 'Bearer',
                //    'total' => $total
        ]);
    }

    public function logout(Request $request){

        return $request->user()->currentAccessToken()->delete();
    }

}
