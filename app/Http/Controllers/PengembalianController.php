<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        if ($role === 1) { // Role ID Superadmin
            $kembali = Pengembalian::with(['peminjaman' => function ($query) {
                $query->orderBy('tgl_kembali', 'asc');
            }])->paginate(5);
        } elseif ($role === 2) { // Role ID Sekda
            // Ambil id dinas yang terkait dengan user yang login
            $dinasId = Auth::user()->dinas_id;

            $kembali = Pengembalian::whereHas('peminjaman', function ($query) use ($dinasId) {
                $query->where(function ($q) {
                    $q->whereIn('status_kembali', ['Menunggu Verifikasi', 'Menunggu Pembayaran']);
                    $q->orWhereIn('status_kembali', ['Menunggu Verifikasi', 'Menunggu Pembayaran']);
                })->whereHas('asets.dinas', function ($q) use ($dinasId) {
                    $q->where('id', $dinasId);
                });
            })
            ->with([
                'peminjaman' => function ($query) {
                    $query->orderBy('tgl_kembali', 'asc');
                },
                'peminjaman.users',
                'peminjaman.asets.dinas'
            ])
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
            return view('pengembalian.superadmin.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('pengembalian.sekda.index', compact('kembali', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
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

                $pengembalian = Pengembalian::with(['peminjaman'])->paginate(5);
                $nama_aset = [];
                $nama_dinas_aset = [];

                foreach ($pengembalian as $pengembalian) {
                    // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
                    if ($pengembalian->peminjaman->asets) {
                        $nama_aset[] = $pengembalian->peminjaman->asets->nama_aset;
                        $nama_dinas_aset[] = $pengembalian->peminjaman->asets->dinas->nama_dinas;
                    } else {
                        $nama_aset[] = null;
                        $nama_dinas_aset[] = null;
                    }
                }

                if ($role_id == 1) {
                    return view('pengembalian.superadmin.riwayat', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 2) {
                    return view('pengembalian.sekda.riwayat', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 3) {
                    return view('pengembalian.opd.riwayat', compact('pengembalian', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                }
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
            return back()->with('error', 'Anda tidak memiliki akses untuk mengajukan pengembalian aset.');
    }

    protected function getPengembalianData($role, $kode_pinjam)
    {
        try {
            $kembali = Pengembalian::with('peminjaman')
                ->where('kode_pinjam', $kode_pinjam)
                ->firstOrFail();

            if ($kembali) {
                $tgl_pinjam_date = null;
                $tgl_pinjam_time = null;
                $tgl_kembali_date = null;
                $tgl_kembali_time = null;

                $peminjaman = $kembali->peminjaman;

                if ($peminjaman) {
                    $tgl_pinjam_date = $peminjaman->tgl_pinjam ? Carbon::parse($peminjaman->tgl_pinjam)->format('d-m-Y') : null;
                    $tgl_pinjam_time = $peminjaman->tgl_pinjam ? Carbon::parse($peminjaman->tgl_pinjam)->format('H:i:s') : null;
                    $tgl_kembali_date = $peminjaman->tgl_kembali ? Carbon::parse($peminjaman->tgl_kembali)->format('d-m-Y') : null;
                    $tgl_kembali_time = $peminjaman->tgl_kembali ? Carbon::parse($peminjaman->tgl_kembali)->format('H:i:s') : null;
                }

                $timestamps = $this->showTimestamp($kembali);

                $view = 'pengembalian.' . $role . '.show';
                return view($view, compact('kembali', 'timestamps', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Data pengembalian tidak ditemukan.');
        }
    }

    public function superadminShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('superadmin', $kode_pinjam);
    }

    public function sekdaShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('sekda', $kode_pinjam);
    }

    public function opdShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPengembalianData('opd', $kode_pinjam);
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
            $query->where('user_id', $userId)->orderBy('tgl_kembali', 'asc');
        })->with(['peminjaman', 'users'])->paginate(5);


        $nama = [];
        $asal_peminjam = [];
        $nama_aset = [];
        $nama_dinas_aset = [];

        $tgl_pinjam_date = [];
        $tgl_pinjam_time = [];
        $tgl_kembali_date = [];
        $tgl_kembali_time = [];

        foreach ($kembali as $pengembalian) {
            // Deklarasi variabel baru untuk setiap iterasi agar nilai sebelumnya tidak tertimpa
            $tgl_pinjam_date_item = null;
            $tgl_pinjam_time_item = null;
            $tgl_kembali_date_item = null;
            $tgl_kembali_time_item = null;

            // Mengurai tanggal pinjam
            if ($pengembalian->peminjaman->tgl_pinjam) {
                $tgl_pinjam = Carbon::parse($pengembalian->peminjaman->tgl_pinjam);
                $tgl_pinjam_date_item = $tgl_pinjam->format('d-m-Y');
                $tgl_pinjam_time_item = $tgl_pinjam->format('H:i:s');
            }

            // Mengurai tanggal kembali
            if ($pengembalian->peminjaman->tgl_kembali) {
                $tgl_kembali = Carbon::parse($pengembalian->peminjaman->tgl_kembali);
                $tgl_kembali_date_item = $tgl_kembali->format('d-m-Y');
                $tgl_kembali_time_item = $tgl_kembali->format('H:i:s');
            }

             // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users ? $pengembalian->peminjaman->users->nama : null;
            $asal_peminjam[] = $pengembalian->peminjaman && $pengembalian->peminjaman->users && $pengembalian->peminjaman->users->dinas  ? $pengembalian->peminjaman->users->dinas->nama_dinas : null;

            $nama_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets ? $pengembalian->peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $pengembalian->peminjaman && $pengembalian->peminjaman->asets && $pengembalian->peminjaman->asets->dinas ? $pengembalian->peminjaman->asets->dinas->nama_dinas : null;

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }

        return view($viewName, compact('kembali','nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
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
        // $kembalian = $kembali->orderBy('tgl_kembali', 'asc')->first();

        $peminjaman = $kembali->peminjaman;

        // Mengurai tanggal pinjam
        $tgl_pinjam_date = null;
        $tgl_pinjam_time = null;

        if ($peminjaman->tgl_pinjam) {
            $tgl_pinjam = Carbon::parse($kembali->peminjaman->tgl_pinjam);
            $tgl_pinjam_date = $tgl_pinjam->format('d-m-Y');
            $tgl_pinjam_time = $tgl_pinjam->format('H:i:s');
        }

        // Mengurai tanggal kembali
        $tgl_kembali_date = null;
        $tgl_kembali_time = null;

        if ($peminjaman->tgl_kembali) {
            $tgl_kembali = Carbon::parse($kembali->peminjaman->tgl_kembali);
            $tgl_kembali_date = $tgl_kembali->format('d-m-Y');
            $tgl_kembali_time = $tgl_kembali->format('H:i:s');
        }

        $timestamps = $this->showTimestamp($kembali);

        $view = 'pengembalian.' . $role . '.showRiwayat';
        return view($view, compact('kembali', 'timestamps', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
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
    public function updateStatus(Request $request, $kode_pinjam)
    {
        $pengembalian = Pengembalian::findOrFail($kode_pinjam);

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

    public function setSanksi(Request $request, $id)
    {
        // Pastikan hanya Superadmin atau Sekda yang bisa mengakses fungsi ini
        $role = $this->getUserRole();
        if ($role !== 1 && $role !== 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        $pengembalian = Pengembalian::findOrFail($id);

        // Lakukan validasi jika diperlukan
        $request->validate([
            'sanksi' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        // Update nominal sanksi pada pengembalian yang dimaksud
        $pengembalian->sanksi = $request->input('sanksi');
        $pengembalian->save();

        return redirect()->back()->with('success', 'Nominal sanksi telah ditetapkan.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }

    public function showTimestamp($user)
    {
        $createdTimestamp = $user->created_at ? $user->created_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;
        $updatedTimestamp = $user->updated_at ? $user->updated_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;
        // $deletedTimestamp = $user->deleted_at ? $user->deleted_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;

        return compact('createdTimestamp', 'updatedTimestamp');
    }
}
