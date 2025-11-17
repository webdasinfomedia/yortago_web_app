<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSubscribed
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
                                                       //updating subscription method isSubscribed check user model
        if ($request->user() && $request->user()->user_type!='private' && !$request->user()->isSubscribed('Subscription')) {
           
            $training_plan = $request->user()->online_training_plan;
            
            if($training_plan)
            {
                if($training_plan->duration == 'life-time')
                    return $next($request);
            }
            return redirect('payout');
        }
        return $next($request);
    }
}