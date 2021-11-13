<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($request->user()->role) || $request->user()->role == 'admin' || $request->user()->role == 'operator'){
            return response()->json(array(
                'code'      =>  403,
                'message'   =>  "Unauthorized"
            ), 403);
        }

        return $next($request);

    }
}
