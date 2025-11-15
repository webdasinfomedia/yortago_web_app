<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ExerciseProgramStatus;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.new_login_form');

        // UPDATE THE LOGIN LAYOUT
        // return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $admin=User::where('email',$request['email'])->where('role','admin')->first();
        if(isset($admin)){
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        $user=   User::where('email',$request['email'])->where('user_type','OnlineTraining')->first();

        if(isset($user)){
           $userStatus=ExerciseProgramStatus::where('user_id',$user['id'])->latest()->first();
           if(isset($userStatus)){
            $date = Carbon::parse($userStatus['date']);
            $now = Carbon::now();

            $diff = $date->diffInDays($now);
            if($diff>=30){
                $user->is_approve_exercise_info=0;
                $user->update();
            }
           }

        }
        // return 1;
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
