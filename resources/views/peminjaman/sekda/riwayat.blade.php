@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.sekda') }}">Dashboard</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Riwayat Peminjaman</li>
        </ol>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Riwayat Peminjaman
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <form class="form-search d-flex" method="GET" action="#">
                        <div class="input-group">
                            <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 15rem; height: 33px"/>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </h6>
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-3">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Kode</th>
                              <th scope="col">Nama Aset</th>
                              <th scope="col">Asal Aset</th>
                              <th scope="col">Waktu Pinjam</th>
                              <th scope="col">Waktu Kembali</th>
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($pinjams->count() > 0)
                            @foreach ($pinjams as $key => $item)
                                <tr class="text-center">
                                    <th style="width: 3rem">{{ ( $pinjams->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->kode_pinjam ) }}</td>

                                    {{-- Tampilkan nama aset dan nama dinas aset --}}
                                    @if(isset($nama_aset[$key]) && isset($nama_dinas_aset[$key]))
                                        <td>{{ $nama_aset[$key] }}</td>
                                        <td>{{ $nama_dinas_aset[$key] }}</td>
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif

                                    <td style="width: 8rem">{{ $tgl_pinjam_date[$key] ?? '' }} {{ $tgl_pinjam_time[$key] ?? '' }}</td>
                                    <td style="width: 8rem">{{ $tgl_kembali_date[$key] ?? '' }} {{ $tgl_kembali_time[$key] ?? '' }}</td>
                                    {{-- <td>{{ ( $item->status_pinjam ) }}</td> --}}
                                    <td style="width: 5rem">
                                        <span class="status-badge @if ($item->status_pinjam === 'Menunggu Verifikasi') text-black bg-warning @elseif ($item->status_pinjam === 'Diterima') text-white bg-success @else text-white bg-danger @endif">{{ $item->status_pinjam }}</span>
                                    </td>
                                    <td class="text-center" style="width: 6rem">
                                        <a class="btn btn-info btn-sm" href="{{ route('peminjaman.sekda.showRiwayat', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-warning btn-sm" href="{{ route('pengembalian.sekda.create', $item->id) }}" role="button"><i class="fa-solid fa-file-export"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
            <div class="card-footer mb-0 pb-0">
                {{ $pinjams->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
