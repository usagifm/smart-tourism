<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = 'vehicle/rent';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'digits:16',],
            'phone' => ['required', 'digits_between:12,13'],
            'ktp' => ['required', 'mimes:jpg,jpeg,png', 'file']
        ], [
            '*.required' => 'Masukkan :attribute',
            '*.string' => 'Masukkan :attribute',
            'email.email' => 'Masukkan email dengan benar',
            'email.unique' => 'Email telah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sesuai',
            'nik.digits' => 'Masukkan 16 digit NIK',
            'phone.digits_between' => 'Masukkan nomor HP 12-13 digit',
            'ktp.mimes' => 'Masukkan file dengan format png, jpg atau jpeg.'
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.user.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'phone' => $request->phone,
            'fcm_registration_id' => ''
        ]);

        if ($request->hasFile('ktp')) {
            $ktp = $request->file('ktp');
            $url = $ktp->move('images/ktp', $ktp->hashName());
            $user->update([
                'photo' => $url->getPath() . '/' . $url->getFilename()
            ]);
        }

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }
}
