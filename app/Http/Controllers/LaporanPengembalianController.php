<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\LaporanPengembalian;
use Illuminate\Support\Facades\Auth;

class LaporanPengembalianController extends Controller
{
    protected function getUserRole()
    {
        return Auth::check() ? Auth::user()->role_id : null;
    }

    public function index()
    {
        $role = $this->getUserRole();

        if ($role === 1) { // Role ID Superadmin
            $kembali = Pengembalian::with(['peminjaman' => function ($query) {
                $query->orderBy('tgl_kembali', 'asc');
            }])->paginate(5);
        } elseif ($role === 2) { // Role ID Sekda
            // Ambil id dinas yang terkait dengan user yang login
            $dinasId = Auth::user()->dinas_id;

            $kembali = Pengembalian::whereHas('peminjaman', function ($query) use ($dinasId) {
                $query->where('id', $dinasId)
                      ->orderBy('tgl_kembali', 'asc'); // Memastikan 'tgl_kembali' adalah kolom yang benar di relasi 'peminjaman'
                })
                ->with(['peminjaman.users', 'peminjaman.asets.dinas'])
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

        foreach ($kembali as $pengembalian) {
            $peminjaman = $pengembalian->peminjaman;

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
            $nama[] = optional($peminjaman->users)->nama;
            $asal_peminjam[] = optional(optional($peminjaman->users)->dinas)->nama_dinas;
            $nama_aset[] = optional($peminjaman->asets)->nama_aset;
            $nama_dinas_aset[] = optional(optional($peminjaman->asets)->dinas)->nama_dinas;

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }


        if ($role === 1) { // Role ID Superadmin
            return view('laporan.pengembalian.superadmin.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('laporan.pengembalian.sekda.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
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
    public function show(LaporanPengembalian $laporanPengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPengembalian $laporanPengembalian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPengembalian $laporanPengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPengembalian $laporanPengembalian)
    {
        //
    }
}
