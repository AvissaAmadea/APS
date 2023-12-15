<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;

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
        $pinjams = Peminjaman::with(['users','asets.dinas'])->paginate(5);

        if (Auth::check()) {
            $nama_dinas_aset = [];
            $nama_aset = [];

            foreach ($pinjams as $peminjaman) {
                // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
                if ($peminjaman->aset) {
                    $nama_dinas_aset[] = optional($peminjaman->aset->dinas)->nama_dinas;
                    $nama_aset[] = optional($peminjaman->aset)->nama_aset;
                } else {
                    $nama_dinas_aset[] = null;
                    $nama_aset[] = null;
                }
            }

            if (Auth::user()->role_id == 1) {
                return view('dashboard.superadmin', compact('pinjams','nama_aset','nama_dinas_aset'));
            } elseif (Auth::user()->role_id == 2) {
                return view('dashboard.sekda', compact('pinjams','nama_aset','nama_dinas_aset'));
            } elseif (Auth::user()->role_id == 3) {
                return view('dashboard.opd', compact('pinjams','nama_dinas_aset'));
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    }

    // public function index(): Renderable|RedirectResponse
    // {
    //     $pinjams = Peminjaman::with(['users', 'asets'])->paginate(5);

    //     if (Auth::check()) {
    //         if (Auth::user()->role_id == 1) {
    //             return view('dashboard.superadmin', compact('pinjams'));
    //         } elseif (Auth::user()->role_id == 2) {
    //             return view('dashboard.sekda', compact('pinjams'));
    //         } elseif (Auth::user()->role_id == 3) {
    //             return view('dashboard.opd', compact('pinjams'));
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }


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
