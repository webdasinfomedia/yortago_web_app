<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthUser
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
        if(Auth::check()){

            if (Auth::user()->role=="user") {

                return $next($request);
            }
            else{
                return redirect(route('admin.dashboard'));
            }
            }
            else{

                return redirect(route('login'));
            }

            return $next($request);


        return $next($request);
    }
}
