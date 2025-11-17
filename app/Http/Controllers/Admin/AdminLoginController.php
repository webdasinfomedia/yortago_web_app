<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{


    public function __construct()
    {
        $this->middleware('guest:web');
    }


    public  function adminIndexLogin(){


        return view('admin.login');
    }


    public function AdminAttemptLogin(Request $request){

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'role' => "admin"])) {

            // return 1;

            return redirect()->intended(route('admin.dashboard'));
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['password' => 'Wrong Password']);
    }
}
