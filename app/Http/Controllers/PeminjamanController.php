<?php

namespace App\Http\Controllers;

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
    protected function getUserRole()
    {
        return Auth::check() ? Auth::user()->role_id : null;
    }

    protected function getIndexData($role)
    {
        // $userId = Auth::id();

        // $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
        //     $query->where('id', $userId);
        // })->with(['asets.dinas'])->paginate(5);

        $pinjams = Peminjaman::with(['asets.dinas']);

        if ($role === 'opd') {
            $userId = Auth::id();
            $pinjams->whereHas('users', function ($query) use ($userId) {
                $query->where('id', $userId);
            });
        }

        $pinjams = $pinjams->paginate(5);

        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }
        }

        $view = 'peminjaman.' . $role . '.index';
        return view($view, compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    }

    public function superadminIndex()
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getIndexData('superadmin');
    }

    public function sekdaIndex()
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getIndexData('sekda');
    }

    public function opdIndex()
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getIndexData('opd');
    }
    public function create()
    {
        $user = Auth::user();
        $asets = Aset::all();
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

                // if (Auth::check()) {
                //     $role_id = Auth::user()->role_id;

                //     if ($role_id == 1) {
                //         return $this->superadmin();
                //     } elseif ($role_id == 2) {
                //         return $this->sekda();
                //     } elseif ($role_id == 3) {
                //         return $this->opd();
                //     }
                // }
            } else {
                return back()->with('error', 'Gagal menyimpan data.');
            }
        } else {
            return back()->with('error', 'File surat peminjaman tidak ditemukan.');
        }

        return back()->with('error', 'Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
    }

    protected function getPeminjamanData($role, $id)
    {
        // $userId = Auth::id();

        // $pinjams = Peminjaman::where('id', $id)
        //     ->whereHas('users', function ($query) use ($userId) {
        //         $query->where('id', $userId);
        // })->with(['users','asets.kategoris','asets.dinas'])->findOrFail($id);

        $pinjams = Peminjaman::with(['users', 'asets.kategoris', 'asets.dinas'])->findOrFail($id);

        // Mengambil data dari objek tunggal $pinjaman, bukan dari array $pinjams
        $nama = $pinjams->users ? $pinjams->users->nama : null;
        $nama_aset = $pinjams->asets ? $pinjams->asets->nama_aset : null;
        $jenis = $pinjams->asets->kategoris ? $pinjams->asets->kategoris->jenis : null;
        $nama_dinas_aset = $pinjams->asets && $pinjams->asets->dinas ? $pinjams->asets->dinas->nama_dinas : null;

        $view = 'peminjaman.' . $role . '.show';
        return view($view, compact('pinjams','nama', 'nama_aset', 'jenis', 'nama_dinas_aset'));
    }

    public function superadminShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 1) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('superadmin', $id);
    }

    public function sekdaShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 2) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('sekda', $id);
    }

    public function opdShow($id)
    {
        $role = $this->getUserRole();

        if ($role != 3) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
        }

        return $this->getPeminjamanData('opd', $id);
    }

    public function showList()
    {
        $role = $this->getUserRole();
        $pinjams = Peminjaman::with(['asets.dinas', 'users'])->paginate(5);

        $nama = [];
        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $peminjaman->users ? $peminjaman->users->nama : null;
            $nama_aset[] = $peminjaman->asets ? $peminjaman->asets->nama_aset : null;

            // Pastikan properti yang mungkin null diakses dengan aman
            $nama_dinas_aset[] = $peminjaman->asets && $peminjaman->asets->dinas ? $peminjaman->asets->dinas->nama_dinas : null;
        }

        if ($role === 1) { // Role ID Superadmin
            return view('peminjaman.superadmin.list', compact('pinjams', 'nama', 'nama_aset', 'nama_dinas_aset'));
        } elseif ($role === 2) { // Role ID Sekda
            return view('peminjaman.sekda.list', compact('pinjams', 'nama', 'nama_aset', 'nama_dinas_aset'));
        } else {

        // Return halaman default untuk role selain Superadmin dan Sekda
        return back();
        }
    }


    // riwayat peminjaman
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
        })->with(['asets.dinas', 'users'])->paginate(5);

        $nama = [];
        $nama_aset = [];
        $nama_dinas_aset = [];

        foreach ($pinjams as $peminjaman) {
            // Menggunakan kondisi jika data tidak ada, maka tampilkan null
            $nama[] = $peminjaman->users ? $peminjaman->users->nama : null;
            $nama_aset[] = $peminjaman->asets ? $peminjaman->asets->nama_aset : null;

            // Pastikan properti yang mungkin null diakses dengan aman
            $nama_dinas_aset[] = $peminjaman->asets && $peminjaman->asets->dinas ? $peminjaman->asets->dinas->nama_dinas : null;
        }

        return view($viewName, compact('pinjams', 'nama', 'nama_aset', 'nama_dinas_aset'));
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

    protected function getRiwayatPeminjamanData($role, $id)
    {
        // $userId = Auth::id();

        // $pinjams = Peminjaman::where('id', $id)
        //     ->whereHas('users', function ($query) use ($userId) {
        //         $query->where('id', $userId);
        // })->with(['users','asets.kategoris','asets.dinas'])->findOrFail($id);

        $pinjams = Peminjaman::with(['users', 'asets.kategoris', 'asets.dinas'])->findOrFail($id);

        // Mengambil data dari objek tunggal $pinjaman, bukan dari array $pinjams
        $nama = $pinjams->users ? $pinjams->users->nama : null;
        $nama_aset = $pinjams->asets ? $pinjams->asets->nama_aset : null;
        $jenis = $pinjams->asets->kategoris ? $pinjams->asets->kategoris->jenis : null;
        $nama_dinas_aset = $pinjams->asets && $pinjams->asets->dinas ? $pinjams->asets->dinas->nama_dinas : null;

        $view = 'peminjaman.' . $role . '.showRiwayat';
        return view($view, compact('pinjams','nama', 'nama_aset', 'jenis', 'nama_dinas_aset'));
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
        $asets = Aset::all();

        return view('peminjaman.superadmin.edit', compact('peminjaman', 'asets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Sekda hanya bisa mengubah status_pinjam
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
            } elseif ($validatedData['status_pinjam'] === 'Ditolak') {
                // Jika status peminjaman berubah menjadi "Ditolak"
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset menjadi "Tersedia"
                    $aset->status_aset = 'Tersedia';
                    $aset->save();
                }
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
            return view('peminjaman.superadmin.list', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
        } else {
            return back()->with('error', 'Gagal menyimpan data.');
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

        // Simpan perubahan pada status_pinjam
        if ($peminjaman->save()) {
            // Jika status peminjaman berubah menjadi "Diterima" atau "Ditolak"
            if ($validatedData['status_pinjam'] === 'Diterima' || $validatedData['status_pinjam'] === 'Ditolak') {
                // Temukan aset yang terlibat dalam peminjaman
                $aset = Aset::find($peminjaman->aset_id);
                if ($aset) {
                    // Ubah status aset sesuai dengan status peminjaman
                    $aset->status_aset = $validatedData['status_pinjam'] === 'Diterima' ? 'Tidak Tersedia' : 'Tersedia';
                    $aset->save();
                }
            }

            return redirect()->route('peminjaman.sekda.list')->with('status', 'Status peminjaman berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal menyimpan perubahan status peminjaman.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
