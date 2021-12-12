<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthGatesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('admin')->user();

        if ($user) {
            $roles            = $user->load('permissions');
            $permissionsArray = [];

            foreach ($roles->permissions as $permissions) {
                $permissionsArray[$permissions->ability][] = $user->id;
            }

            foreach ($permissionsArray as $ability => $roles) {
                Gate::define($ability, function (Admin $admin) use ($roles) {
                    return $admin->id == $roles[0];
                });
            }
        }

        return $next($request);
    }
}
