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
        if ($user->role_id == 1) {
            return redirect()->route('dashboard.superadmin'); // Redirect superadmin to their dashboard
        } elseif ($user->role_id == 2) {
            return redirect()->route('dashboard.sekda'); // Redirect sekda to their dashboard
        } elseif ($user->role_id == 3) {
            return redirect()->route('dashboard.opd'); // Redirect opd to their dashboard
        }

        // Default redirect if the user role doesn't match expected roles
        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    // logout method
    public function logout()
    {
        Auth::guard('user')->logout(); // This method will invalidate the authenticated user's session

        return redirect('/login'); // Redirect to a login page or any other page after logout
    }
}
