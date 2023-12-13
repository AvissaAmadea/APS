<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:peminjaman,kode_pinjam',
            'user_id' => 'required|exists:users,id',
            'aset_id' => 'required|exists:asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
            'tujuan' => 'required',
            'surat_pinjam' => 'required|file|mimes:jpg,jpeg,png,doc,docx,pdf|max:2048',
            'status_pinjam' => [
                'required',
                Rule::in(['Diterima', 'Menunggu Verifikasi', 'Ditolak']),
            ],
        ]);

        // Pastikan file diunggah sebelum mencoba mengakses ekstensinya
        if ($request->hasFile('surat_pinjam')) {
            $fileName = time().'.'.$request->file('surat_pinjam')->extension();
            $request->file('surat_pinjam')->move(public_path('uploads'), $fileName);
        } else {
            return back()->with('error', 'File surat peminjaman tidak ditemukan.');
        }

        // Menggunakan model Eloquent untuk menyimpan data ke database
        $peminjaman = new Peminjaman();
        $peminjaman->kode_pinjam = $request->kode_pinjam;
        $peminjaman->user_id = $request->user_id;
        $peminjaman->aset_id = $request->aset_id;
        $peminjaman->tgl_pinjam = $request->tgl_pinjam;
        $peminjaman->tgl_kembali = $request->tgl_kembali;
        $peminjaman->tujuan = $request->tujuan;
        $peminjaman->surat_pinjam = $fileName;
        $peminjaman->status_pinjam = 'Menunggu Verifikasi';
        $peminjaman->created_at = now();

        // Simpan data
        $peminjaman->save();

        // DB::table('peminjaman')->insert([
        //     'kode_pinjam' => $request->kode_pinjam,
        //     'user_id' => $request->user_id,
        //     'aset_id' => $request->aset_id,
        //     'tgl_pinjam' => $request->tgl_pinjam,
        //     'tgl_kembali' => $request->tgl_kembali,
        //     'tujuan' => $request->tujuan,
        //     'surat_pinjam' => $fileName,
        //     'status_pinjam' => $request->status_pinjam,
        //     'created_at' => now(),
        // ]);

        // nanti di return redirect ke riwayat
        return redirect('peminjaman')->with('status','Permohonan Peminjaman Aset berhasil diajukan.');
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
