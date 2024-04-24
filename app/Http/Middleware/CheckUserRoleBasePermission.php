<?php

namespace App\Http\Middleware;

use App\Enumeration\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRoleBasePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        if ($roles) {
            if (in_array(Auth::user()->role, explode('-', $roles))) {
                return $next($request);
            }
        }
        return abort('401');

    }
}
