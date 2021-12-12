<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ManageOperatorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('manage_operator'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operators = Operator::all();

        return view('operator.index', compact('operators'));
    }

    public function resetToken(Operator $operator)
    {
        abort_if(Gate::denies('manage_operator'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operator->tokens()->delete();

        return redirect()->route('manage.operator.index');
    }
}
