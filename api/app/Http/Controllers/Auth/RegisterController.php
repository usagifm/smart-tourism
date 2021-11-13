<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register(Request $request){

        $request->validate([
            'name'=>['required'],
            'email'=>['required', 'email', 'unique:users,email'],
            'password'=>['required','min:8', 'confirmed'],
            'nik'=>  'required|digits:16|numeric',
            'phone' => 'required|min:10|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(($request->password)),
            'nik' => $request->nik,
            'phone' => $request->phone,
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                   'access_token' => $token,
                   'token_type' => 'Bearer',
        ]);
    }
}
