<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(): Renderable|RedirectResponse
    {
        $pinjams = [];

        if (Auth::check()) {
            $role_id = Auth::user()->role_id;

            if ($role_id == 1) {
                return $this->superadmin();
            } elseif ($role_id == 2) {
                return $this->sekda();
            } elseif ($role_id == 3) {
                return $this->opd();
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    }

    protected function superadmin()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran superadmin
        if(Auth::user()->role_id != 1) {
            // Redirect atau tampilkan pesan error jika pengguna bukan superadmin
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Superadmin');
        }

        // $userId = Auth::id();

        $users = User::count();
        $kategoris = Kategori::count();
        $allAsets = Aset::count();
        $peminjamans = Peminjaman::count();
        $pengembalians = Pengembalian::count();

        // Peminjaman

        // Ambil data peminjaman per bulan dalam satu tahun
        $dataPeminjamanPerBulan = Peminjaman::select(
            DB::raw("COUNT(*) as count"),
            DB::raw("MONTH(tgl_pinjam) as month")
        )
        ->whereYear('tgl_pinjam', Carbon::now()->year)
        ->groupBy(DB::raw("MONTH(tgl_pinjam)"))
        ->orderBy(DB::raw("MONTH(tgl_pinjam)"))
        ->pluck('count', 'month');

        // Siapkan label bulan
        $labelsPeminjaman = [];
        $jumlahPeminjamanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $labelsPeminjaman[] = Carbon::createFromFormat('m', $i)->format('M');
            $jumlahPeminjamanPerBulan[] = $dataPeminjamanPerBulan[$i] ?? 0;
        }

        // Mendapatkan tahun-tahun unik dari tabel Peminjaman
        $tahunPeminjaman = Peminjaman::selectRaw('YEAR(tgl_pinjam) as tahun')
        ->distinct()
        ->pluck('tahun');

        // Mengambil semua peminjaman tanpa batasan
        $pinjams = Peminjaman::with(['asets.dinas'])->orderBy('tgl_pinjam', 'asc')->paginate(5);

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

            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }

        // Pengembalian

        // Ambil data pengembalian per bulan dalam satu tahun
        // Ambil data pengembalian per bulan dalam satu tahun dari tabel Peminjaman
        $dataPengembalianPerBulan = Pengembalian::join('peminjaman', 'pengembalian.kode_pinjam', '=', 'peminjaman.kode_pinjam')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTH(peminjaman.tgl_kembali) as month")
            )
            ->whereNotNull('peminjaman.tgl_kembali')
            ->whereYear('peminjaman.tgl_kembali', Carbon::now()->year)
            ->groupBy(DB::raw("MONTH(peminjaman.tgl_kembali)"))
            ->orderBy(DB::raw("MONTH(peminjaman.tgl_kembali)"))
            ->pluck('count', 'month');

        // Siapkan label bulan untuk grafik pengembalian
        $labelsPengembalian = [];
        $jumlahPengembalianPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $labelsPengembalian[] = Carbon::createFromFormat('m', $i)->format('M');
            $jumlahPengembalianPerBulan[] = $dataPengembalianPerBulan[$i] ?? 0;
        }

        $tahunPengembalian = Pengembalian::join('peminjaman', 'pengembalian.kode_pinjam', '=', 'peminjaman.kode_pinjam')
        ->selectRaw('YEAR(peminjaman.tgl_kembali) as tahun')
        ->distinct()
        ->pluck('tahun');

        $kembali = Pengembalian::whereNotNull('kode_pinjam')
        ->with(['peminjaman' => function ($query) {
            $query->orderBy('tgl_kembali', 'asc');
        }, 'peminjaman.asets.dinas'])
        ->paginate(5);

        foreach ($kembali as $pengembalian) {
            $peminjaman = $pengembalian->peminjaman;

            if ($peminjaman) {
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
                $nama_aset[] = optional($peminjaman->asets)->nama_aset;
                $nama_dinas_aset[] = optional(optional($peminjaman->asets)->dinas)->nama_dinas;

                $tgl_pinjam_date[] = $tgl_pinjam_date_item;
                $tgl_pinjam_time[] = $tgl_pinjam_time_item;
                $tgl_kembali_date[] = $tgl_kembali_date_item;
                $tgl_kembali_time[] = $tgl_kembali_time_item;
            } else {
                // Jika $peminjaman tidak ada, tambahkan nilai default
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
                $tgl_pinjam_date[] = null;
                $tgl_pinjam_time[] = null;
                $tgl_kembali_date[] = null;
                $tgl_kembali_time[] = null;
            }
        }

        // aset =
        $asets = Aset::with(['dinas', 'kategoris'])->paginate(5);

        // Jika pengguna memiliki peran superadmin, tampilkan halaman dashboard superadmin
        return view('dashboard.superadmin', [
            'users' => $users,
            'kategoris' => $kategoris,
            'allAsets' => $allAsets,
            'peminjamans' => $peminjamans,
            'pengembalians' => $pengembalians,
            'pinjams' => $pinjams,
            'kembali' => $kembali,
            'nama_aset' => $nama_aset,
            'nama_dinas_aset' => $nama_dinas_aset,
            'tgl_pinjam_date' => $tgl_pinjam_date,
            'tgl_pinjam_time' => $tgl_pinjam_time,
            'tgl_kembali_date' => $tgl_kembali_date,
            'tgl_kembali_time' => $tgl_kembali_time,
            'labelsPeminjaman' => json_encode($labelsPeminjaman), // Ubah labels menjadi labelsPeminjaman
            'jumlahPeminjamanPerBulan' => json_encode($jumlahPeminjamanPerBulan),
            'tahunPeminjaman' => json_encode($tahunPeminjaman),
            'labelsPengembalian' => json_encode($labelsPengembalian), // Tambahkan labels untuk grafik pengembalian
            'jumlahPengembalianPerBulan' => json_encode($jumlahPengembalianPerBulan), // Tambahkan jumlah pengembalian untuk grafik pengembalian
            'tahunPengembalian' => json_encode($tahunPengembalian),
            'asets' => $asets,
        ]);
    }

    protected function sekda()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran sekda
        if(Auth::user()->role_id != 2) {
            // Redirect atau tampilkan pesan error jika pengguna bukan sekda
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Sekda');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 2)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

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

            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }

        // Jika pengguna memiliki peran sekda, tampilkan halaman dashboard sekda
        return view('dashboard.sekda', compact('pinjams', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
    }

    protected function opd()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran opd
        if(Auth::user()->role_id != 3) {
            // Redirect atau tampilkan pesan error jika pengguna bukan opd
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai OPD');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 3)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

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

            // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
            if ($peminjaman->asets) {
                $nama_aset[] = $peminjaman->asets->nama_aset;
                $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
            } else {
                $nama_aset[] = null;
                $nama_dinas_aset[] = null;
            }

            $tgl_pinjam_date[] = $tgl_pinjam_date_item;
            $tgl_pinjam_time[] = $tgl_pinjam_time_item;
            $tgl_kembali_date[] = $tgl_kembali_date_item;
            $tgl_kembali_time[] = $tgl_kembali_time_item;
        }

            // Jika pengguna memiliki peran opd, tampilkan halaman dashboard opd
            return view('dashboard.opd', compact('pinjams', 'nama_aset', 'nama_dinas_aset', 'tgl_pinjam_date', 'tgl_pinjam_time', 'tgl_kembali_date', 'tgl_kembali_time'));
    }
}
