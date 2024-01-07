<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPeminjamanController extends Controller
{
    protected function getUserRole()
    {
        return Auth::check() ? Auth::user()->role_id : null;
    }

    //index blm kepake
    public function index()
    {
        $role = $this->getUserRole();

        if ($role === 1) { // Role ID Superadmin
            $pinjams = Peminjaman::with(['asets.dinas', 'users'])->orderBy('tgl_pinjam', 'asc')->paginate(5);
        } elseif ($role === 2) { // Role ID Sekda
            // Ambil id dinas yang terkait dengan user yang login
            $dinasId = Auth::user()->dinas_id;

            $pinjams = Peminjaman::whereHas('asets.dinas', function ($query) use ($dinasId) {
                    $query->where('id', $dinasId);
                })
                ->with(['asets.dinas', 'users'])
                ->paginate(5);
        } else {
            // Return halaman default untuk role selain Superadmin dan Sekda
            return back();
        }

        $nama = [];
        $asal_peminjam = [];
        $nama_aset = [];
        $nama_dinas_aset = [];

        $tgl_pinjam_date = [];
        $tgl_pinjam_time = [];
        $tgl_kembali_date = [];
        $tgl_kembali_time = [];

        foreach ($pinjams as $peminjaman) {
            // Deklarasi variabel baru untuk setiap iterasi agar nilai sebelumnya tidak tertimpa
            $tgl_pinjam_date_item = null;
            $tgl_pinjam_time_item = null;
            $tgl_kembali_date_item = null;
            $tgl_kembali_time_item = null;

            // Mengurai tanggal pinjam
            if ($peminjaman->tgl_pinjam) {
                $tgl_pinjam = Carbon::parse($peminjaman->tgl_pinjam);
                $tgl_pinjam_date_item = $tgl_pinjam->format('d-m-Y');
                $tgl_pinjam_time_item = $tgl_pinjam->format('H:i:s');
            }

            // Mengurai tanggal kembali
            if ($peminjaman->tgl_kembali) {
                $tgl_kembali = Carbon::parse($peminjaman->tgl_kembali);
                $tgl_kembali_date_item = $tgl_kembali->format('d-m-Y');
                $tgl_kembali_time_item = $tgl_kembali->format('H:i:s');
            }

            // Menambahkan nilai ke dalam array sesuai dengan variabel yang telah diuraikan
            $nama[] = $peminjaman->users ? $peminjaman->users->nama : null;
            $asal_peminjam[] = $peminjaman->users && $peminjaman->users->dinas ? $peminjaman->users->dinas->nama_dinas : null;
            $nama_aset[] = $peminjaman->asets ? $peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $peminjaman->asets && $peminjaman->asets->dinas ? $peminjaman->asets->dinas->nama_dinas : null;

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }


        if ($role === 1) { // Role ID Superadmin
            return view('laporan.peminjaman.superadmin.index', compact('pinjams', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('laporan.peminjaman.sekda.index', compact('pinjams', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } else {

        // Return halaman default untuk role selain Superadmin dan Sekda
        return back();
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
