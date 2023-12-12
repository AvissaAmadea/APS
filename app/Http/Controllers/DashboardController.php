<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('dashboard.superadmin');
        } else if (Auth::user()->role_id == 2) {
            return redirect()->route('dashboard.sekda');
        } else if (Auth::user()->role_id == 3) {
            return redirect()->route('dashboard.opd');
        } else {
            return view('auth.login');
        }
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
        } else {
            // Jika pengguna memiliki peran superadmin, tampilkan halaman dashboard superadmin
            return view('dashboard.superadmin')->with('status', 'Selamat Datang Super Admin!');
        }
    }

    public function sekda()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran sekda
        if(Auth::user()->role_id != 2) {
            // Redirect atau tampilkan pesan error jika pengguna bukan sekda
            return redirect()->route('/login')->with('error', 'Anda tidak memiliki akses sebagai Sekda');
        } else {
            // Jika pengguna memiliki peran sekda, tampilkan halaman dashboard sekda
            return view('dashboard.sekda')->with('status', 'Selamat Datang Sekretaris Daerah!');
        }
    }

    public function opd()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran opd
        if(Auth::user()->role_id != 3) {
            // Redirect atau tampilkan pesan error jika pengguna bukan opd
            return redirect()->route('/login')->with('error', 'Anda tidak memiliki akses sebagai OPD');
        } else {
            // Jika pengguna memiliki peran opd, tampilkan halaman dashboard opd
            return view('dashboard.opd')->with('status', 'Selamat Datang OPD!');
        }
    }
}
