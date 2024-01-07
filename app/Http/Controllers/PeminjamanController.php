<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Dinas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class PeminjamanController extends Controller
{
    // cek dan mendapatkan role user
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
                ->where('status_pinjam', 'Menunggu Verifikasi') // Menambahkan kondisi status 'Menunggu Verifikasi'
                ->with(['asets.dinas', 'users'])
                ->orderBy('tgl_pinjam', 'asc')
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
            return view('peminjaman.superadmin.index', compact('pinjams', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('peminjaman.sekda.index', compact('pinjams', 'nama', 'asal_peminjam', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
        } else {

        // Return halaman default untuk role selain Superadmin dan Sekda
        return back();
        }
    }

    // fungsi insert peminjaman
    public function create()
    {
        $user = Auth::user();
        $asets = Aset::where('status_aset', 'Tersedia')->get();
        // $pinjams = [];

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

    // fungsi menyimpan data dari insert peminjaman
    public function store(Request $request)
    {
        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'kode_pinjam' => 'required|unique:peminjaman,kode_pinjam',
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
                // Mengubah status aset menjadi "Tidak Tersedia" setelah peminjaman berhasil
                $aset_id = $validatedData['aset_id'];
                $aset = Aset::find($aset_id);
                if ($aset) {
                    $aset->status_aset = 'Tidak Tersedia';
                    $aset->save();
                }

                $role_id = Auth::user()->role_id;
                $message = 'Permohonan Peminjaman Aset berhasil diajukan.';

                $pinjams = Peminjaman::with(['asets.dinas'])->paginate(5);
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

                if ($role_id == 1) {
                    return view('dashboard.superadmin', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 2) {
                    return view('dashboard.sekda', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                } elseif ($role_id == 3) {
                    return view('dashboard.opd', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                }
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
        } else {
            return back()->with('error', 'File surat peminjaman tidak ditemukan.');
        }

        return back()->with('error', 'Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
    }

    // Fungsi menampilkan data peminjaman yang dilakukan oleh semua user
    protected function getPeminjamanData($role, $kode_pinjam)
    {
        $user = Auth::user(); // Mendapatkan informasi user yang sedang login

        $pinjams = Peminjaman::with(['users', 'asets.kategoris', 'asets.dinas'])
            ->where('kode_pinjam', $kode_pinjam) // Menggunakan kode_pinjam untuk mencari detail peminjaman
            ->firstOrFail();

        if ($pinjams) {
            // Mengurai tanggal pinjam
            $tgl_pinjam_date = null;
            $tgl_pinjam_time = null;

            if ($pinjams->tgl_pinjam) {
                $tgl_pinjam = Carbon::parse($pinjams->tgl_pinjam);
                $tgl_pinjam_date = $tgl_pinjam->format('d-m-Y');
                $tgl_pinjam_time = $tgl_pinjam->format('H:i:s');
            }

            // Mengurai tanggal kembali
            $tgl_kembali_date = null;
            $tgl_kembali_time = null;

            if ($pinjams->tgl_kembali) {
                $tgl_kembali = Carbon::parse($pinjams->tgl_kembali);
                $tgl_kembali_date = $tgl_kembali->format('d-m-Y');
                $tgl_kembali_time = $tgl_kembali->format('H:i:s');
            }
        } else {
            return back();
        }

        // Mengambil data dari objek tunggal $pinjaman, bukan dari array $pinjams
        $nama = $pinjams->users ? $pinjams->users->nama : null;
        $nama_aset = $pinjams->asets ? $pinjams->asets->nama_aset : null;
        $jenis = $pinjams->asets->kategoris ? $pinjams->asets->kategoris->jenis : null;
        $nama_dinas_aset = $pinjams->asets && $pinjams->asets->dinas ? $pinjams->asets->dinas->nama_dinas : null;
        $status_pinjam = $pinjams->status_pinjam ?? '-';

        $timestamps = $this->showTimestamp($pinjams);

        $view = 'peminjaman.' . $role . '.show';
        return view($view, compact('pinjams','nama', 'nama_aset', 'jenis', 'nama_dinas_aset', 'timestamps', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time', 'status_pinjam'));
    }

    public function superadminShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('superadmin', $kode_pinjam);
    }

    public function sekdaShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('sekda', $kode_pinjam);
    }

    public function opdShow($kode_pinjam)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('opd', $kode_pinjam);
    }


    // fungsi mendapatkan beberapa data peminjaman yang akan ditampilkan di tampilan riwayat peminjaman berdasarkan role user dengan id user yang digunakan
    public function riwayatPeminjamanByRole($role, $viewName)
    {
        $userRole = $this->getUserRole();

        // Memastikan role sesuai dengan yang diperlukan
        if ($userRole != $role) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        // Menampilkan riwayat peminjaman yang dilakukan oleh user dengan role_id yang sesuai
        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->with(['asets.dinas', 'users'])->orderBy('tgl_pinjam', 'asc')->paginate(5);

        $nama = [];
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
            $nama_aset[] = $peminjaman->asets ? $peminjaman->asets->nama_aset : null;
            $nama_dinas_aset[] = $peminjaman->asets && $peminjaman->asets->dinas ? $peminjaman->asets->dinas->nama_dinas : null;

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }

        return view($viewName, compact('pinjams', 'nama', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
    }

    public function riwayatPinjamSuperadmin()
    {
        return $this->riwayatPeminjamanByRole(1, 'peminjaman.superadmin.riwayat');
    }

    public function riwayatPinjamSekda()
    {
        return $this->riwayatPeminjamanByRole(2, 'peminjaman.sekda.riwayat');
    }

    public function riwayatPinjamOpd()
    {
        return $this->riwayatPeminjamanByRole(3, 'peminjaman.opd.riwayat');
    }

    // fungsi mendapatkan semua data peminjaman yang akan ditampilkan di tampilan detail riwayat peminjaman berdasarkan role user dengan id user yang digunakan
    protected function getRiwayatPeminjamanData($role, $id)
    {
        $pinjams = Peminjaman::with(['users', 'asets.kategoris', 'asets.dinas'])->findOrFail($id)->orderBy('tgl_pinjam', 'asc');

        // Mengurai tanggal pinjam
        $tgl_pinjam_date = null;
        $tgl_pinjam_time = null;

        if ($pinjams->tgl_pinjam) {
            $tgl_pinjam = Carbon::parse($pinjams->tgl_pinjam);
            $tgl_pinjam_date = $tgl_pinjam->format('d-m-Y');
            $tgl_pinjam_time = $tgl_pinjam->format('H:i:s');
        }

        // Mengurai tanggal kembali
        $tgl_kembali_date = null;
        $tgl_kembali_time = null;

        if ($pinjams->tgl_kembali) {
            $tgl_kembali = Carbon::parse($pinjams->tgl_kembali);
            $tgl_kembali_date = $tgl_kembali->format('d-m-Y');
            $tgl_kembali_time = $tgl_kembali->format('H:i:s');
        }

        // Mengambil data dari objek tunggal $pinjaman, bukan dari array $pinjams
        $nama = $pinjams->users ? $pinjams->users->nama : null;
        $nama_aset = $pinjams->asets ? $pinjams->asets->nama_aset : null;
        $jenis = $pinjams->asets->kategoris ? $pinjams->asets->kategoris->jenis : null;
        $nama_dinas_aset = $pinjams->asets && $pinjams->asets->dinas ? $pinjams->asets->dinas->nama_dinas : null;
        $timestamps = $this->showTimestamp($pinjams);

        $view = 'peminjaman.' . $role . '.showRiwayat';
        return view($view, compact('pinjams','nama', 'nama_aset', 'jenis', 'nama_dinas_aset', 'timestamps', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
    }

    public function superadminShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPeminjamanData('superadmin', $id);
    }

    public function sekdaShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPeminjamanData('sekda', $id);
    }

    public function opdShowRiwayat($id)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getRiwayatPeminjamanData('opd', $id);
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

        $peminjaman = Peminjaman::findOrFail($id);
        $asets = Aset::where('status_aset', 'Tersedia')->get();

        return view('peminjaman.superadmin.edit', compact('peminjaman', 'asets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Superadmin dapat mengupdate data
        if (Auth::user()->role_id != 1) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah data.');
        }

        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'tujuan' => 'required',
            'surat_pinjam' => 'required|file|mimes:jpg,jpeg,png,doc,docx,pdf|max:2048',
            'status_pinjam' => 'required|in:Menunggu Verifikasi,Diterima,Ditolak',
        ]);

        // Update data peminjaman
        $peminjaman->fill($validatedData);

        // Simpan perubahan pada status_pinjam
        if ($peminjaman->save()) {
            // Jika status peminjaman berubah menjadi "Diterima"
            if ($validatedData['status_pinjam'] === 'Diterima') {
                // Temukan aset yang terlibat dalam peminjaman
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tidak Tersedia"
                    $aset->status_aset = 'Tidak Tersedia';
                    $aset->save();
                }
            } elseif ($validatedData['status_pinjam'] === 'Menunggu Verifikasi') {
                // Jika status peminjaman berubah menjadi "Menunggu Verifikasi"
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tidak Tersedia"
                    $aset->status_aset = 'Tidak Tersedia Tersedia';
                    $aset->save();
                }
            } elseif ($validatedData['status_pinjam'] === 'Ditolak') {
                // Jika status peminjaman berubah menjadi "Ditolak"
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tersedia"
                    $aset->status_aset = 'Tersedia';
                    $aset->save();
                }

            $message = 'Permohonan Peminjaman Aset berhasil diperbarui.';

            $pinjams = Peminjaman::with(['asets.dinas'])->paginate(5);
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
            return view('peminjaman.superadmin.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
        }
    }

    // update status pinjam oleh sekda
    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan user yang melakukan verifikasi adalah sekda atau superadmin
        $userRole = $this->getUserRole();
        if ($userRole != 1 && $userRole != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai untuk verifikasi.');
        }
        // Lakukan validasi input dari form
        $validatedData = $request->validate([
            'status_pinjam' => 'required|in:Menunggu Verifikasi,Diterima,Ditolak', // Atur opsi status yang dapat diubah
        ]);

        // Update status peminjaman
        $peminjaman->status_pinjam = $validatedData['status_pinjam'];

        if ($peminjaman->save()) {
            // Jika status peminjaman berubah menjadi "Diterima" atau "Ditolak" atau "Menunggu Verifikasi"
            if ($validatedData['status_pinjam'] === 'Diterima' || $validatedData['status_pinjam'] === 'Ditolak' || $validatedData['status_pinjam'] === 'Menunggu Verifikasi') {
                // Temukan aset yang terlibat dalam peminjaman
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset sesuai dengan status peminjaman
                    $status_aset = $validatedData['status_pinjam'] === 'Diterima' ? 'Tidak Tersedia' : 'Tersedia';

                    // Jika status peminjaman menjadi "Menunggu Verifikasi"
                    if ($validatedData['status_pinjam'] === 'Menunggu Verifikasi') {
                        $status_aset = 'Tidak Tersedia';
                    }

                    $aset->status_aset = $status_aset;
                    $aset->save();
                }
            }
            return redirect()->route('peminjaman.sekda.index')->with('status', 'Status peminjaman berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal menyimpan perubahan status peminjaman.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pinjams = Peminjaman::findOrFail($id);

        // Hanya bisa menghapus jika status pinjam adalah "Menunggu Verifikasi"
        if ($pinjams->status_pinjam === 'Menunggu Verifikasi') {
            $aset = Aset::find($pinjams->aset_id);

            // Mencari batas waktu cancel peminjaman (6 jam sebelum waktu pinjam)
            $waktuPinjam = Carbon::createFromTimestamp($pinjams->tgl_pinjam)->subHours(6);

            // Jika waktu sekarang masih sebelum batas waktu cancel
            if (Carbon::now()->greaterThanOrEqualTo($waktuPinjam)) {
                if ($pinjams->delete()) {
                    // Ubah status aset menjadi "Tersedia" setelah penghapusan berhasil
                    if ($aset) {
                        $aset->status_aset = 'Tersedia';
                        $aset->save();
                    }

                    // Redirect ke halaman riwayat peminjaman sesuai dengan role pengguna
                    $userRole = $this->getUserRole();
                    if ($userRole === 1) {
                        return redirect()->route('peminjaman.superadmin.riwayat')->with('status', 'Data peminjaman berhasil dihapus.');
                    } elseif ($userRole === 2) {
                        return redirect()->route('peminjaman.sekda.riwayat')->with('status', 'Data peminjaman berhasil dihapus.');
                    } elseif ($userRole === 3) {
                        return redirect()->route('peminjaman.opd.riwayat')->with('status', 'Data peminjaman berhasil dihapus.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Gagal menghapus data peminjaman.');
                }
            } else {
                return redirect()->back()->with('error', 'Batas waktu pembatalan peminjaman telah berakhir.');
            }
        } else {
            return redirect()->back()->with('error', 'Hanya peminjaman dengan status "Menunggu Verifikasi" yang dapat dihapus.');
        }
    }

    public function showTimestamp($user)
    {
        $createdTimestamp = $user->created_at ? $user->created_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;
        $updatedTimestamp = $user->updated_at ? $user->updated_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;
        $deletedTimestamp = $user->deleted_at ? $user->deleted_at->isoFormat('DD-MM-YYYY HH:mm:ss') : null;

        return compact('createdTimestamp', 'updatedTimestamp', 'deletedTimestamp');
    }

}
