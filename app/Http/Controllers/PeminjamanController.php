<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(): Renderable|RedirectResponse
     {
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

         return back()->with('error', 'Anda tidak memiliki akses yang sesuai.');
     }

     protected function superadmin()
    {
        // Lakukan pengecekan apakah pengguna memiliki peran superadmin
        if(Auth::user()->role_id != 1) {
            // Redirect atau tampilkan pesan error jika pengguna bukan superadmin
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Superadmin');
        }

        $userId = Auth::id();

        $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
            $query->where('role_id', 1)->where('id', $userId);
        })->with(['asets.dinas'])->paginate(5);

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

        // Jika pengguna memiliki peran superadmin, tampilkan halaman peminjaman superadmin
        return view('peminjaman.superadmin.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
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

        // Jika pengguna memiliki peran sekda, tampilkan halaman peminjaman sekda
        return view('peminjaman.sekda.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
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

            // Jika pengguna memiliki peran opd, tampilkan halaman peminjaman opd
            return view('peminjaman.opd.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    }

    //  protected function superadmin()
    //  {
    //      if (Auth::user()->role_id != 1) {
    //          return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Superadmin');
    //      }

    //      $userId = Auth::id();

    //      $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //          $query->where('role_id', 1)->where('id', $userId);
    //      })->with(['asets.dinas'])->paginate(5);

    //      return $this->renderPeminjaman('peminjaman.superadmin.index', $pinjams);
    //  }

    //  protected function sekda()
    //  {
    //      if (Auth::user()->role_id != 2) {
    //          return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai Sekda');
    //      }

    //      $userId = Auth::id();

    //      $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //          $query->where('role_id', 2)->where('id', $userId);
    //      })->with(['asets.dinas'])->paginate(5);

    //      if ($pinjams->isEmpty()) {
    //         // Jika tidak ada data, kembalikan halaman tanpa data
    //         return view('peminjaman.sekda.index')->with('pinjams', collect()); // Mengirim collection kosong
    //     }

    //      return $this->renderPeminjaman('peminjaman.sekda.index', $pinjams);
    //  }

    //  protected function opd()
    //  {
    //      if (Auth::user()->role_id != 3) {
    //          return redirect()->route('login')->with('error', 'Anda tidak memiliki akses sebagai OPD');
    //      }

    //      $userId = Auth::id();

    //      $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //          $query->where('role_id', 3)->where('id', $userId);
    //      })->with(['asets.dinas'])->paginate(5);

    //      return $this->renderPeminjaman('peminjaman.opd.index', $pinjams);
    //  }

    //  protected function renderPeminjaman($view, $pinjams)
    //  {
    //      $nama_aset = [];
    //      $nama_dinas_aset = [];

    //      foreach ($pinjams as $peminjaman) {
    //          if ($peminjaman->asets) {
    //              $nama_aset[] = $peminjaman->asets->nama_aset;
    //              $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
    //          } else {
    //              $nama_aset[] = null;
    //              $nama_dinas_aset[] = null;
    //          }
    //      }

    //      return view($view, compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //  }

    // public function superadminIndex()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();

    //         if ($user->role_id == 1) {
    //             $userId = Auth::id();

    //             $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //                 $query->where('id', $userId);
    //             })->with(['asets.dinas'])->paginate(5);

    //             $nama_aset = [];
    //             $nama_dinas_aset = [];

    //             foreach ($pinjams as $peminjaman) {
    //                 // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
    //                 if ($peminjaman->asets) {
    //                     $nama_aset[] = $peminjaman->asets->nama_aset;
    //                     $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
    //                 } else {
    //                     $nama_aset[] = null;
    //                     $nama_dinas_aset[] = null;
    //                 }
    //             }

    //             return view('peminjaman.superadmin.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         } else {
    //             return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }

    // public function sekdaIndex()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();

    //         if ($user->role_id == 2) {
    //             $userId = Auth::id();

    //             $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //                 $query->where('id', $userId);
    //             })->with(['asets.dinas'])->paginate(5);

    //             $nama_aset = [];
    //             $nama_dinas_aset = [];

    //             foreach ($pinjams as $peminjaman) {
    //                 // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
    //                 if ($peminjaman->asets) {
    //                     $nama_aset[] = $peminjaman->asets->nama_aset;
    //                     $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
    //                 } else {
    //                     $nama_aset[] = null;
    //                     $nama_dinas_aset[] = null;
    //                 }
    //             }

    //             return view('peminjaman.sekda.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         } else {
    //             return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }

    // public function opdIndex()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();

    //         if ($user->role_id == 3) {
    //             $userId = Auth::id();

    //             $pinjams = Peminjaman::whereHas('users', function ($query) use ($userId) {
    //                 $query->where('id', $userId);
    //             })->with(['asets.dinas'])->paginate(5);

    //             $nama_aset = [];
    //             $nama_dinas_aset = [];

    //             foreach ($pinjams as $peminjaman) {
    //                 // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
    //                 if ($peminjaman->asets) {
    //                     $nama_aset[] = $peminjaman->asets->nama_aset;
    //                     $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
    //                 } else {
    //                     $nama_aset[] = null;
    //                     $nama_dinas_aset[] = null;
    //                 }
    //             }

    //             return view('peminjaman.opd.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         } else {
    //             return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $asets = Aset::all();
        $pinjams = [];

        if ($user->role_id == 1) {
            return view('peminjaman.superadmin.create', compact('asets', 'user', 'pinjams'));
        } elseif ($user->role_id == 2) {
            return view('peminjaman.sekda.create', compact('asets', 'user', 'pinjams'));
        } elseif ($user->role_id == 3) {
            return view('peminjaman.opd.create', compact('asets', 'user', 'pinjams'));
        } else {
            return back()->with('error','Anda tidak memiliki akses untuk mengajukan peminjaman aset.');
        }

    }

    // public function index()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $pinjams = Peminjaman::with(['users','asets'])->paginate(5);
    //         $nama_aset = [];
    //         $nama_dinas_aset = [];

    //         foreach ($pinjams as $peminjaman) {
    //             // Pastikan bahwa aset tidak null sebelum mencoba mengakses dinas
    //             if ($peminjaman->asets) {
    //                 $nama_aset[] = $peminjaman->asets->nama_aset;
    //                 $nama_dinas_aset[] = $peminjaman->asets->dinas->nama_dinas;
    //             } else {
    //                 $nama_aset[] = null;
    //                 $nama_dinas_aset[] = null;
    //             }
    //         }

    //         if ($user->role_id == 1) {
    //             return view('peminjaman.superadmin.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         } elseif ($user->role_id == 2) {
    //             return view('peminjaman.sekda.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         } elseif ($user->role_id == 3) {
    //             return view('peminjaman.opd.index', compact('pinjams', 'nama_aset', 'nama_dinas_aset'));
    //         }
    //     }

    //     return redirect()->route('login')->with('error', 'Anda tidak memiliki akses yang sesuai.');
    // }

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

                // if ($role_id == 1) {
                //     return view('dashboard.superadmin', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                // } elseif ($role_id == 2) {
                //     return view('dashboard.sekda', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                // } elseif ($role_id == 3) {
                //     return view('dashboard.opd', compact('pinjams', 'nama_aset', 'nama_dinas_aset'))->with('status', $message);
                // }

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
    public function edit(Peminjaman $peminjaman, $id)
    {
        // Hanya sekda yang dapat mengedit status_pinjam
        if (Auth::user()->role_id != 2) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit data.');
        }

        $peminjaman = Peminjaman::findOrFail($id);
        $aset = Aset::findOrFail($id);


        return view('peminjaman.edit', compact('peminjaman', 'aset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Sekda hanya bisa mengubah status_pinjam
        if (Auth::user()->role_id != 2) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah data.');
        }

        // Melakukan validasi input dari form
        $validatedData = $request->validate([
            'status_pinjam' => 'required|in:Menunggu Verifikasi,Diterima,Ditolak', // Atur opsi status yang dapat diubah
        ]);

        // Update data peminjaman hanya untuk status_pinjam
        $peminjaman->status_pinjam = $validatedData['status_pinjam'];

        // Simpan perubahan pada status_pinjam
        if ($peminjaman->save()) {
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
