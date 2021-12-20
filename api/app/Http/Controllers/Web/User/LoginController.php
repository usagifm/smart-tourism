<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.user.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendFailedLoginResponse($request);
        }

        return redirect()->route('dashboard');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Credentials invalid'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.user');
    }
}
