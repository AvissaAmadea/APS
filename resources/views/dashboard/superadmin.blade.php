@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h6>{{ __('Dashboard Super Admin') }}</h6>
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
                                    {{-- @foreach ($nama_aset as $nama_aset)
                                            <td>{{ $nama_aset }}</td>
                                    @endforeach --}}
                                    @if ($nama_aset !== null)
                                        @foreach ($nama_aset as $nama_aset)
                                            <td>{{ $nama_aset }}</td>
                                        @endforeach
                                    @endif

                                    {{-- @foreach ($nama_dinas_aset as $nama_dinas)
                                            <td>{{ $nama_dinas }}</td>
                                    @endforeach --}}
                                    @if ($nama_dinas_aset !== null)
                                        @foreach ($nama_dinas_aset as $nama_dinas)
                                            <td>{{ $nama_dinas }}</td>
                                        @endforeach
                                    @endif

                                    <td>{{ ( $item->tgl_pinjam ) }}</td>
                                    <td>{{ ( $item->tgl_kembali ) }}</td>
                                    <td>{{ ( $item->status_pinjam ) }}</td>
                                    {{-- <td>
                                        <span class="status-badge @if ($item->status_aset === 'Tersedia') text-white bg-primary @else text-white bg-secondary @endif">{{ $item->status_aset }}</span>
                                    </td> --}}
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="{{ url('peminjaman/sekda/show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-file-export"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                      </tbody>
                  </table>
                <!-- </div> -->
                {{-- <table class="table table-bordered border-dark align-middle">
                    <thead >
                        <tr class="text-center table-dark">
                            <th scope="col">No.</th>
                            <th scope="col">Nama Aset</th>
                            <th scope="col">Asal Dinas</th>
                            <th scope="col">Waktu Pinjam</th>
                            <th scope="col">Waktu Kembali</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">{{ __('1') }}</th>
                            <td>{{ __('Aset') }}</td>
                            <td>{{ __('Dinas Sosial') }}</td>
                            <td>{{ __('10-03-2024') }}</td>
                            <td>{{ __('15-03-2024') }}</td>
                            <td class="text-center">{{ __('Status') }}</td>
                        </tr>
                    </tbody>
                </table> --}}
            </div>
            <div class="col d-flex flex-fill mx-2 align-items-center justify-content-end">
                {{ $pinjams->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

