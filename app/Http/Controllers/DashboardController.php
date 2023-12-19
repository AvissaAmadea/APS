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
        $pinjams = [];

        if (Auth::check()) {
            $role_id = Auth::user()->role_id;

            if ($role_id == 1) {
                return $this->superadmin();
            } elseif ($role_id == 2) {
                return $this->sekda();
            } elseif ($role_id == 3) {
                return $this->opd();
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    }

    // public function index(): Renderable|RedirectResponse
    // {
    //     $pinjams = [];

    //     if (Auth::check()) {
    //         $role_id = Auth::user()->role_id;

    //         if ($role_id == 1) {
    //             return $this->superadmin();
    //         } elseif ($role_id == 2) {
    //             return $this->sekda();
    //         } elseif ($role_id == 3) {
    //             return $this->opd();
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }

    protected function superadmin()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran superadmin
        if(Auth::user()->role_id != 1) {
            // Redirect atau tampilkan pesan error jika pengguna bukan superadmin
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Superadmin');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 1)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }
        }

        // Jika pengguna memiliki peran superadmin, tampilkan halaman dashboard superadmin
        return view('dashboard.superadmin', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    }

    protected function sekda()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran sekda
        if(Auth::user()->role_id != 2) {
            // Redirect atau tampilkan pesan error jika pengguna bukan sekda
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Sekda');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 2)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }
        }

        // Jika pengguna memiliki peran sekda, tampilkan halaman dashboard sekda
        return view('dashboard.sekda', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    }

    protected function opd()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran opd
        if(Auth::user()->role_id != 3) {
            // Redirect atau tampilkan pesan error jika pengguna bukan opd
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai OPD');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 3)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }
        }

            // Jika pengguna memiliki peran opd, tampilkan halaman dashboard opd
            return view('dashboard.opd', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    }
}
