<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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
    protected $redirectTo = '/dashboard';

    // protected function authenticated(Request $request, $user)
    // {
    //     if ($user->role_id == 1) {
    //         return view('dashboard.superadmin')->with('status', 'Selamat Datang Super Admin!'); // Redirect superadmin to their dashboard
    //     } elseif ($user->role_id == 2) {
    //         return view('dashboard.sekda')->with('status', 'Selamat Datang Sekretaris Daerah!'); // Redirect sekda to their dashboard
    //     } elseif ($user->role_id == 3) {
    //         return view('dashboard.opd')->with('status', 'Selamat Datang OPD!'); // Redirect opd to their dashboard
    //     } else {
    //         // Default redirect if the user role doesn't match expected roles
    //         return redirect('/login')->with('error', 'Silahkan Registrasi terlebih dahulu!');
    //     }
    // }

    protected function authenticated(Request $request, $user)
    {
        $redirectTo = '';

        if ($user->role_id == 1) {
            $redirectTo = 'dashboard.superadmin';
            $role = 'Super Admin';
        } elseif ($user->role_id == 2) {
            $redirectTo = 'dashboard.sekda';
            $role = 'Sekretaris Daerah';
        } elseif ($user->role_id == 3) {
            $redirectTo = 'dashboard.opd';
            $role = 'OPD';
        }

        return redirect()->route($redirectTo)->with('status', 'Selamat Datang, ' . $role . '!');
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

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::flush(); // Membersihkan data sesi terkait

        return $this->loggedOut($request) ?: redirect('/');
    }
}
