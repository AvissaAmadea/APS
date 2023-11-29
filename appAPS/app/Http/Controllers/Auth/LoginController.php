<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated(Request $request, $user)
    {
        if ($user->role->id === 1) {
            return redirect()->route('superadmin.dashboard'); // Redirect superadmin to their dashboard
        } elseif ($user->role->id === 2) {
            return redirect()->route('sekda.dashboard'); // Redirect sekda to their dashboard
        } elseif ($user->role->id === 3) {
            return redirect()->route('opd.dashboard'); // Redirect opd to their dashboard
        }

        // Default redirect if the user role doesn't match expected roles
        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id === 1) { //'1' is the role_id for superadmin
                return redirect()->route('superadmin.dashboard');
            } elseif ($user->role_id === 2) { // '2' for sekda
                return redirect()->route('sekda.dashboard');
            } elseif ($user->role_id === 3) { // '3' for opd
                return redirect()->route('opd.dashboard');
            }
        }

        return back()->withErrors(['email'=> 'Invalid credentials']);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
