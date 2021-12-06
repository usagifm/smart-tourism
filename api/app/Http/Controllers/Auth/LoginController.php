<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Data yang anda masukan salah"
            ), 401);
        }

        $total = $user->tokens()->count();

        if($total >= 1){
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Akun hanya bisa dalam 1 perangkat !"
            ), 401);

        }

        $user->fcm_registration_id = $request->fcm_registration_id;
        $user->save();


        $token = $user->createToken('auth_token')->plainTextToken;

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
