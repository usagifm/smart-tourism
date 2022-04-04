<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'nik' =>  'required|digits:16|numeric',
            'phone' => 'required|min:10|numeric',
            // 'photo' => ['required']
        ]);

        if ($request->photo) {
            $imageName = $this->upload($request->photo);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(($request->password)),
            'nik' => $request->nik,
            'phone' => $request->phone,
            'fcm_registration_id' => $request->fcm_registration_id,
            'photo' => "storage/images/ktp/{$imageName}"
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function upload($file)
    {
        $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        $replace = substr($file, 0, strpos($file, ',') + 1);
        $image = str_replace($replace, '', $file);

        $image = str_replace(' ', '+', $image);

        $imageName = Str::random(40) . '.' . $extension;
        Storage::disk('public')->put("images/ktp/{$imageName}", base64_decode($image));
        return $imageName;
    }
}
