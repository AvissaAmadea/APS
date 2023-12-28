<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    protected function getUserRole()
    {
        return Auth::check() ? Auth::user()->role_id : null;
    }

    public function getPembayaranByRole($role, $viewName)
    {
        $userRole = $this->getUserRole();

        // Memastikan role sesuai dengan yang diperlukan
        if ($userRole != $role) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        // Menampilkan riwayat peminjaman yang dilakukan oleh user dengan role_id yang sesuai
        $userId = Auth::id();

        $kembali = Pengembalian::whereHas('peminjaman', function ($query) use ($userId) {
            $query->where('user_id', $userId); // Ganti 'users_id' dengan kolom yang sesuai dalam tabel 'peminjaman'
        })->with(['peminjaman', 'users'])->paginate(5);

        $nama = [];
        $nama_aset = [];
        $nama_dinas_aset = [];
        $sanksi = [];

        foreach ($kembali as $pengembalian) {
             // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users ? $pengembalian->peminjaman->users->nama : null;
            $nama_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets ? $pengembalian->peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets && $pengembalian->peminjaman->asets->dinas ? $pengembalian->peminjaman->asets->dinas->nama_dinas : null;
            $sanksi[] = $pengembalian->sanksi ;
        }

        return view($viewName, compact('kembali','nama', 'nama_aset', 'nama_dinas_aset', 'sanksi'));
    }

    public function pembayaranSuperadmin()
    {
        return $this->getPembayaranByRole(1, 'pembayaran.superadmin.index');
    }

    public function pembayaranSekda()
    {
        return $this->getPembayaranByRole(2, 'pembayaran.sekda.index');
    }

    public function pembayaranOpd()
    {
        return $this->getPembayaranByRole(3, 'pembayaran.opd.index');
    }

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
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
