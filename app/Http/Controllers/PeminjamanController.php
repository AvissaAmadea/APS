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
        if (Auth::check()) {
            $user = Auth::user();
            $pinjams = Peminjaman::with(['users','asets'])->paginate(5);

            if ($user->role_id == 1) {
                return view('peminjaman.superadmin.index', compact('pinjams'));
            } elseif ($user->role_id == 2) {
                return view('peminjaman.sekda.index', compact('pinjams'));
            } elseif ($user->role_id == 3) {
                return view('peminjaman.opd.index', compact('pinjams'));
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $asets = Aset::all();

        if ($user->role_id == 1) {
            return view('peminjaman.superadmin.create', compact('asets', 'user'));
        } elseif ($user->role_id == 2) {
            return view('peminjaman.sekda.create', compact('asets', 'user'));
        } elseif ($user->role_id == 3) {
            return view('peminjaman.opd.create', compact('asets', 'user'));
        } else {
            return back()->with('error','Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
        }

    }

    // protected function validator(Request $request)
    // {
    //     return $request->validate([
    //         'kode_pinjam' => 'required|unique:peminjaman,kode_pinjam',
    //         'user_id' => 'required|exists:users,id',
    //         'aset_id' => 'required|exists:asets,id',
    //         'tgl_pinjam' => 'required|date',
    //         'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
    //         'tujuan' => 'required',
    //         'surat_pinjam' => 'required|file|mimes:jpg,jpeg,png,doc,docx,pdf|max:2048',
    //         // 'status_pinjam' => [
    //         //     'required',
    //         //     Rule::in(['Diterima', 'Menunggu Verifikasi', 'Ditolak']),
    //         // ],
    //     ]);
    // }


    public function store(Request $request)
    {
        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:peminjaman,kode_pinjam',
            // 'user_id' => 'required|exists:users,id',
            'aset_id' => 'required|exists:asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'tujuan' => 'required',
            'surat_pinjam' => 'required|file|mimes:jpg,jpeg,png,doc,docx,pdf|max:2048',
        ]);

        // Pastikan file diunggah sebelum mencoba mengakses ekstensinya
        if ($request->hasFile('surat_pinjam')) {
            $fileName = time().'.'.$request->file('surat_pinjam')->extension();
            $request->file('surat_pinjam')->move(public_path('uploads'), $fileName);

            // Simpan data peminjaman ke dalam database
            $peminjaman = new Peminjaman([
                'kode_pinjam' => $validatedData['kode_pinjam'],
                'user_id' => Auth::id(),
                'aset_id' => $validatedData['aset_id'],
                'tgl_pinjam' => $validatedData['tgl_pinjam'],
                'tgl_kembali' => $validatedData['tgl_kembali'],
                'tujuan' => $validatedData['tujuan'],
                'surat_pinjam' => $fileName,
                'status_pinjam' => 'Menunggu Verifikasi',
            ]);

            if ($peminjaman->save()) {
                $role_id = Auth::user()->role_id;
                $message = 'Permohonan Peminjaman Aset berhasil diajukan.';

                if ($role_id == 1) {
                    return view('dashboard.superadmin')->with('status', $message);
                } elseif ($role_id == 2) {
                    return view('dashboard.sekda')->with('status', $message);
                } elseif ($role_id == 3) {
                    return view('dashboard.opd')->with('status', $message);
                }
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
        } else {
            return back()->with('error', 'File surat peminjaman tidak ditemukan.');
        }

        return back()->with('error', 'Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
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
