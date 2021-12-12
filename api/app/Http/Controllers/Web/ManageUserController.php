<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ManageUserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_customer'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function resetToken(User $user)
    {
        abort_if(Gate::denies('manage_customer'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->tokens()->delete();

        return redirect()->route('manage.user.index');
    }
}
