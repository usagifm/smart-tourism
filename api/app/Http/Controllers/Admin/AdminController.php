<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request){
        return $request->user();
    }
}
