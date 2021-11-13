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
                'message'   =>  "The provided credentials are incorrect."
            ), 401);
        }

        $total = $user->tokens()->count();

        if($total >= 1){
            return response()->json(array(
                'code'      =>  401,
                'message'   =>  "Can only login in one device! "
            ), 401);

        }

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
