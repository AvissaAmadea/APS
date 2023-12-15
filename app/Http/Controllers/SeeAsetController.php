<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Dinas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeeAsetController extends Controller
{
    public function index()
    {
        $asets = Aset::with(['dinas', 'kategoris'])->paginate(5);

        $role_id = Auth::user()->role_id;

        if ($role_id == 2) {
            return view('seeAset.sekda.index', compact('asets'));
        } elseif ($role_id == 3) {
            return view('seeAset.opd.index', compact('asets'));
        } else {
            // return view('aset.seeAset', compact('asets'));
            if ($role_id == 1) {
                return view('dashboard.superadmin')->with('status', 'Selamat Datang Super Admin!'); // Redirect superadmin to their dashboard
            } elseif ($role_id == 2) {
                return view('dashboard.sekda')->with('status', 'Selamat Datang Sekretaris Daerah!'); // Redirect sekda to their dashboard
            } elseif ($role_id == 3) {
                return view('dashboard.opd')->with('status', 'Selamat Datang OPD!'); // Redirect opd to their dashboard
            } else {
                // Default redirect if the user role doesn't match expected roles
                return redirect('/login')->with('error', 'Silahkan Registrasi terlebih dahulu!');
            }
        }
    }

    public function show(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);
        $dinas = Dinas::find($request->input('dinas_id'));
        $kategoris = Kategori::find($request->input('kategori_id'));

        // return view('aset.show', compact('aset','dinas','kategoris'));

        $role_id = Auth::user()->role_id;

        if ($role_id == 2) {
            return view('seeAset.sekda.show', compact('aset','dinas','kategoris'));
        } elseif ($role_id == 3) {
            return view('seeAset.opd.show', compact('aset','dinas','kategoris'));
        } else {
            // return view('aset.seeAset', compact('asets'));
            if ($role_id == 1) {
                return view('dashboard.superadmin')->with('status', 'Selamat Datang Super Admin!'); // Redirect superadmin to their dashboard
            } elseif ($role_id == 2) {
                return view('dashboard.sekda')->with('status', 'Selamat Datang Sekretaris Daerah!'); // Redirect sekda to their dashboard
            } elseif ($role_id == 3) {
                return view('dashboard.opd')->with('status', 'Selamat Datang OPD!'); // Redirect opd to their dashboard
            } else {
                // Default redirect if the user role doesn't match expected roles
                return redirect('/login')->with('error', 'Silahkan Registrasi terlebih dahulu!');
            }
        }
    }
}
