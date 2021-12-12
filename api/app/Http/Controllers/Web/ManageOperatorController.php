<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;

class ManageOperatorController extends Controller
{
    public function index()
    {
        $operators = Operator::all();

        return view('operator.index', compact('operators'));
    }

    public function resetToken(Operator $operator)
    {
        $operator->tokens()->delete();

        return redirect()->route('manage.operator.index');
    }
}
