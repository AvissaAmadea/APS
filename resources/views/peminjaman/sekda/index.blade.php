@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Riwayat') }}</strong></h6>
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
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-2">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Kode</th>
                              <th scope="col">Nama Aset</th>
                              <th scope="col">Dinas</th>
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
                                    <th>{{ ( $pinjams->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->kode_pinjam ) }}</td>

                                    {{-- Tampilkan nama aset dan nama dinas aset --}}
                                    @if(isset($nama_aset[$key]) && isset($nama_dinas_aset[$key]))
                                        <td>{{ $nama_aset[$key] }}</td>
                                        <td>{{ $nama_dinas_aset[$key] }}</td>
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif

                                    <td>{{ ( $item->tgl_pinjam ) }}</td>
                                    <td>{{ ( $item->tgl_kembali ) }}</td>
                                    {{-- <td>{{ ( $item->status_pinjam ) }}</td> --}}
                                    <td style="width: 5rem">
                                        <span class="status-badge @if ($item->status_pinjam === 'Menunggu Verifikasi') text-black bg-warning @elseif ($item->status_pinjam === 'Diterima') text-white bg-success @else text-white bg-danger @endif">{{ $item->status_pinjam }}</span>
                                    </td>
                                    <td class="text-center" style="width: 6rem">
                                        <a class="btn btn-info btn-sm" href="{{ url('peminjaman/sekda/show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-file-export"></i></a>
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
            <div class="col d-flex flex-fill mx-2 align-items-center justify-content-end">
                {{ $pinjams->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

