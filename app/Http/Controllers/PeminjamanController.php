<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjams = Peminjaman::with(['users','asets'])->paginate(5);

        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('peminjaman.superadmin.index', compact('users','asets'));
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->route('peminjaman.sekda.index', compact('users','asets'));
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('peminjaman.opd.index', compact('users','asets'));
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $asets = Aset::all();
        $role_id = Auth::user()->role_id;

        if ($role_id == 1) {
            return view('peminjaman.superadmin.create', compact('asets'));
        } elseif ($role_id == 2) {
            return view('peminjaman.sekda.create', compact('asets'));
        } elseif ($role_id == 3) {
            return view('peminjaman.opd.create', compact('asets'));
        } else {
            return back()->with('error','Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
        }

    }

    protected function validator(Request $request)
    {
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:peminjaman,kode_pinjam',
            'user_id' => 'required|exists:users,id',
            'aset_id' => 'required|exists:asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
            'tujuan' => 'required',
            'surat_pinjam' => 'required|file|mimes:jpg,jpeg,png,doc,docx,pdf|max:2048',
            // 'status_pinjam' => [
            //     'required',
            //     Rule::in(['Diterima', 'Menunggu Verifikasi', 'Ditolak']),
            // ],
        ]);

        return $validatedData;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan file diunggah sebelum mencoba mengakses ekstensinya
        if ($request->hasFile('surat_pinjam')) {
            $fileName = time().'.'.$request->file('surat_pinjam')->extension();
            $request->file('surat_pinjam')->move(public_path('uploads'), $fileName);
        } else {
            return back()->with('error', 'File surat peminjaman tidak ditemukan.');
        }

        DB::table('peminjaman')->insert([
            'kode_pinjam' => $request->kode_pinjam,
            'user_id' => $request->user_id,
            'aset_id' => $request->aset_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'tujuan' => $request->tujuan,
            'surat_pinjam' => $fileName,
            'status_pinjam' => $request->status_pinjam,
            'created_at' => now(),
        ]);

        // nanti di return redirect ke riwayat
        // return redirect('peminjaman')->with('status','Permohonan Peminjaman Aset berhasil diajukan.');

        $role_id = Auth::user()->role_id;

        if ($role_id == 1) {
            return view('dashboard.superadmin')->with('status','Permohonan Peminjaman Aset berhasil diajukan.');
        } elseif ($role_id == 2) {
            return view('dashboard.sekda')->with('status','Permohonan Peminjaman Aset berhasil diajukan.');
        } elseif ($role_id == 3) {
            return view('dashboard.opd')->with('status','Permohonan Peminjaman Aset berhasil diajukan.');
        } else {
            return back()->with('error','Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
