<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    // cek dan mendapatkan role user
    protected function getUserRole()
    {
        return Auth::check() ? Auth::user()->role_id : null;
    }

    public function index()
    {
        $role = $this->getUserRole();
        // $kembali = null;

        if ($role === 1) { // Role ID Superadmin
            $kembali = Pengembalian::with(['peminjaman'])->paginate(5);
        } elseif ($role === 2) { // Role ID Sekda
            // Ambil id dinas yang terkait dengan user yang login
            $dinasId = Auth::user()->dinas_id;

            $kembali = Pengembalian::whereHas('peminjaman', function ($query) use ($dinasId) {
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
        $tglPinjam = [];
        $tglKembali = [];

        foreach ($kembali as $pengembalian) {
             // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users ? $pengembalian->peminjaman->users->nama : null;
            $asal_peminjam[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users && $pengembalian->peminjaman->users->dinas  ? $pengembalian->peminjaman->users->dinas->nama_dinas : null;

            $nama_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets ? $pengembalian->peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets && $pengembalian->peminjaman->asets->dinas ? $pengembalian->peminjaman->asets->dinas->nama_dinas : null;

            $tglPinjam[] = $pengembalian->peminjaman ? $pengembalian->peminjaman->tgl_pinjam : null;
            $tglKembali[] = $pengembalian->peminjaman ? $pengembalian->peminjaman->tgl_kembali : null;
        }

        if ($role === 1) { // Role ID Superadmin
            return view('pengembalian.superadmin.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset','tglPinjam','tglKembali'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('pengembalian.sekda.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset','tglPinjam','tglKembali'));
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
        $user = Auth::user();

        if ($user->role_id == 1) {
            return view('pengembalian.superadmin.create', compact('user'));
        } elseif ($user->role_id == 2) {
            return view('pengembalian.sekda.create', compact('user'));
        } elseif ($user->role_id == 3) {
            return view('pengembalian.opd.create', compact('user'));
        } else {
            return back()->with('error','Anda tidak memiliki akses untuk mengajukan pengembalian aset.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:pengembalian,kode_pinjam',
            'rusak' => 'required|in:Ya,Tidak',
            'hilang' => 'required|in:Ya,Tidak',
            'ket_rusak' => 'required_if:rusak,Ya',
            'ket_hilang' => 'required_if:hilang,Ya',
            'bukti' => 'required_if:rusak,Ya|required_if:hilang,Ya|file|mimes:jpeg,png,jpg,doc,docx,pdf|max:2048',
        ]);

            // Simpan data ke dalam tabel pengembalian
            $pengembalian = new Pengembalian([
                'kode_pinjam' => $validatedData['kode_pinjam'],
                'rusak' => $validatedData['rusak'],
                'hilang' => $validatedData['hilang'],
                'ket_rusak' => $validatedData['ket_rusak'],
                'ket_hilang' => $validatedData['ket_hilang'],
                'status_kembali' => 'Menunggu Verifikasi',
            ]);

            // Upload foto kerusakan jika ada
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                // $file->storeAs('rusak', $fileName);
                $file->move(public_path('uploads'), $fileName);

                // Simpan nama foto ke dalam model pengembalian
                $pengembalian->bukti = $fileName;
            }

            if ($pengembalian->save()) {
                $role_id = Auth::user()->role_id;
                $message = 'Permohonan Pengembalian Aset berhasil diajukan.';

                $pengembalian = Pengembalian::with(['asets.dinas'])->paginate(5);
                $nama_aset = [];
                $nama_dinas_aset = [];

                foreach ($pengembalian as $pengembalian) {
                    // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
                    if ($pengembalian->asets) {
                        $nama_aset[] = $pengembalian->asets->nama_aset;
                        $nama_dinas_aset[] = $pengembalian->asets->dinas->nama_dinas;
                    } else {
                        $nama_aset[] = null;
                        $nama_dinas_aset[] = null;
                    }
                }

                if ($role_id == 1) {
                    return view('pengembalian.superadmin.index', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 2) {
                    return view('pengembalian.sekda.index', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 3) {
                    return view('pengembalian.opd.index', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                }
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
            return back()->with('error', 'Anda tidak memiliki akses untuk mengajukan pengembalian aset.');
    }

    protected function getPengembalianData($role, $id)
    {
        $kembali = Pengembalian::with(['peminjaman'])->findOrFail($id);

        // Mengambil data dari objek tunggal $pinjaman, bukan dari array $pinjams
        // $nama = $kembali->peminjaman && $kembali->peminjaman->users ? $kembali->peminjaman->users->nama : null;
        // $asal_peminjam = $kembali->peminjaman && $kembali->peminjaman->users && $kembali->peminjaman->users->dinas  ? $kembali->peminjaman->users->dinas->nama_dinas : null;

        // $nama_aset = $kembali->peminjaman && $kembali->peminjaman->asets ? $kembali->peminjaman->asets->nama_aset : null;
        // $nama_dinas_aset = $kembali->peminjaman && $kembali->peminjaman->asets && $kembali->peminjaman->asets->dinas ? $kembali->peminjaman->asets->dinas->nama_dinas : null;

        // $tglPinjam = $kembali->peminjaman ? $kembali->peminjaman->tgl_pinjam : null;
        // $tglKembali = $kembali->peminjaman ? $kembali->peminjaman->tgl_kembali : null;

        $view = 'pengembalian.' . $role . '.show';
        return view($view, compact('kembali'));
    }

    public function superadminShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('superadmin', $id);
    }

    public function sekdaShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('sekda', $id);
    }

    public function opdShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('opd', $id);
    }


    public function riwayatPengembalianByRole($role, $viewName)
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
        $asal_peminjam = [];
        $nama_aset = [];
        $nama_dinas_aset = [];
        $tglPinjam = [];
        $tglKembali = [];

        foreach ($kembali as $pengembalian) {
             // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users ? $pengembalian->peminjaman->users->nama : null;
            $asal_peminjam[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users && $pengembalian->peminjaman->users->dinas  ? $pengembalian->peminjaman->users->dinas->nama_dinas : null;

            $nama_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets ? $pengembalian->peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets && $pengembalian->peminjaman->asets->dinas ? $pengembalian->peminjaman->asets->dinas->nama_dinas : null;

            $tglPinjam[] = $pengembalian->peminjaman ? $pengembalian->peminjaman->tgl_pinjam : null;
            $tglKembali[] = $pengembalian->peminjaman ? $pengembalian->peminjaman->tgl_kembali : null;
        }

        return view($viewName, compact('kembali','nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset','tglPinjam','tglKembali'));
    }

    public function riwayatKembaliSuperadmin()
    {
        return $this->riwayatPengembalianByRole(1, 'pengembalian.superadmin.riwayat');
    }

    public function riwayatKembaliSekda()
    {
        return $this->riwayatPengembalianByRole(2, 'pengembalian.sekda.riwayat');
    }

    public function riwayatKembaliOpd()
    {
        return $this->riwayatPengembalianByRole(3, 'pengembalian.opd.riwayat');
    }

    protected function getRiwayatPengembalianData($role, $id)
    {
        $kembali = Pengembalian::with(['peminjaman'])->findOrFail($id);

        $view = 'pengembalian.' . $role . '.showRiwayat';
        return view($view, compact('kembali'));
    }

    public function superadminShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPengembalianData('superadmin', $id);
    }

    public function sekdaShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPengembalianData('sekda', $id);
    }

    public function opdShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPengembalianData('opd', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Hanya sekda yang dapat mengedit status_pinjam
        if (Auth::user()->role_id != 1) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit data.');
        }

        $pengembalian = Pengembalian::findOrFail($id);

        return view('pengembalian.superadmin.edit', compact('pengembalian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        // Superadmin dapat mengupdate data
        if (Auth::user()->role_id != 1) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah data.');
        }

        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:pengembalian,kode_pinjam',
            'rusak' => 'required|in:Ya,Tidak',
            'hilang' => 'required|in:Ya,Tidak',
            'ket_rusak' => 'required_if:rusak,Ya',
            'ket_hilang' => 'required_if:hilang,Ya',
            'bukti' => 'required_if:rusak,Ya|required_if:hilang,Ya|file|mimes:jpeg,png,jpg,doc,docx,pdf|max:2048',
        ]);

        // Update data peminjaman
        $pengembalian->fill($validatedData);

        // Simpan perubahan pada status_pinjam
        if ($pengembalian->save()) {
            // Jika status pengembalian berubah menjadi "Diterima"
            if ($validatedData['status_kembali'] === 'Diterima') {
                // Temukan aset yang terlibat dalam peminjaman
                $aset = Aset::find($pengembalian->peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tidak Tersedia"
                    $aset->status_aset = 'Tersedia';
                    $aset->save();
                }
            } elseif ($validatedData['status_kembali'] === 'Menunggu Verifikasi') {
                // Jika status pengembalian berubah menjadi "Menunggu Verifikasi"
                $aset = Aset::find($pengembalian->peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tidak Tersedia"
                    $aset->status_aset = 'Tidak Tersedia';
                    $aset->save();
                }
            } elseif ($validatedData['status_kembali'] === 'Menunggu Pembayaran') {
                // Jika status pengembalian berubah menjadi "Menunggu Pembayaran"
                $aset = Aset::find($pengembalian->peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tidak Tersedia"
                    $aset->status_aset = 'Tidak Tersedia';
                    $aset->save();
                }
            } elseif ($validatedData['status_kembali'] === 'Ditolak') {
                // Jika status pengembalian berubah menjadi "Ditolak"
                $aset = Aset::find($pengembalian->peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tersedia"
                    $aset->status_aset = 'Tidak Tersedia';
                    $aset->save();
                }

            $message = 'Permohonan Peminjaman Aset berhasil diperbarui.';

            $pengembalian = Pengembalian::with(['peminjaman'])->paginate(5);

            return view('pengembalian.superadmin.index', compact('pengembalian'))->with('status', $message);
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
        }
    }

    // update status pinjam oleh sekda
    public function updateStatus(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // Pastikan user yang melakukan verifikasi adalah sekda atau superadmin
        $userRole = $this->getUserRole();
        if ($userRole != 1 && $userRole != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai untuk verifikasi.');
        }
        // Lakukan validasi input dari form
        $validatedData = $request->validate([
            'status_kembali' => 'required|in:Menunggu Verifikasi,Menunggu Pembayaran,Diterima,Ditolak', // Atur opsi status yang dapat diubah
        ]);

        // Update status peminjaman
        $pengembalian->status_kembali = $validatedData['status_kembali'];

        if ($pengembalian->save()) {
            // Jika status peminjaman berubah menjadi "Diterima" atau "Ditolak" atau "Menunggu Verifikasi"
            if ($validatedData['status_kembali'] === 'Diterima' || $validatedData['status_kembali'] === 'Ditolak' || $validatedData['status_kembali'] === 'Menunggu Verifikasi' || $validatedData['status_kembali'] === 'Menunggu Pembayaran') {
                // Temukan aset yang terlibat dalam peminjaman
                $aset = Aset::find($pengembalian->peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset sesuai dengan status peminjaman
                    $status_aset = $validatedData['status_kembali'] === 'Diterima' ? 'Tersedia' : 'Tidak Tersedia';

                    // Jika status peminjaman menjadi "Menunggu Verifikasi"
                    if ($validatedData['status_kembali'] === 'Menunggu Verifikasi' || $validatedData['status_kembali'] === 'Diterima' || $validatedData['status_kembali'] === 'Menunggu Pembayaran') {
                        $status_aset = 'Tidak Tersedia';
                    }

                    $aset->status_aset = $status_aset;
                    $aset->save();
                }
            }
            return redirect()->route('pengembalian.sekda.index')->with('status', 'Status pengembalian berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal menyimpan perubahan status peminjaman.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}