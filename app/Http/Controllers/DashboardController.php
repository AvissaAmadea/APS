<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(): Renderable|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('dashboard.superadmin');
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->route('dashboard.sekda');
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('dashboard.opd');
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');

        // if (Auth::user()->role_id == 1) {
        //     return view('dashboard.superadmin');
        // } else if (Auth::user()->role_id == 2) {
        //     return view('dashboard.sekda');
        // } else if (Auth::user()->role_id == 3) {
        //     return view('dashboard.opd');
        // } else {
        //     return view('/login');
        // }
    }

    public function superadmin()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran superadmin
        if(Auth::user()->role_id != 1) {
            // Redirect atau tampilkan pesan error jika pengguna bukan superadmin
            return redirect()->route('/login')->with('error', 'Anda tidak memiliki akses sebagai Superadmin');
        }
            // Jika pengguna memiliki peran superadmin, tampilkan halaman dashboard superadmin
            return view('dashboard.superadmin');

        // return view('dashboard.superadmin');
    }

    public function sekda()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran sekda
        if(Auth::user()->role_id != 2) {
            // Redirect atau tampilkan pesan error jika pengguna bukan sekda
            return redirect()->route('/login')->with('error', 'Anda tidak memiliki akses sebagai Sekda');
        }
            // Jika pengguna memiliki peran sekda, tampilkan halaman dashboard sekda
            return view('dashboard.sekda');

    }

    public function opd()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran opd
        if(Auth::user()->role_id != 3) {
            // Redirect atau tampilkan pesan error jika pengguna bukan opd
            return redirect()->route('/login')->with('error', 'Anda tidak memiliki akses sebagai OPD');
        }
            // Jika pengguna memiliki peran opd, tampilkan halaman dashboard opd
            return view('dashboard.opd');

    }
}
