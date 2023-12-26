@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.sekda') }}">Dashboard</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Lihat Aset</li>
        </ol>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Lihat Aset
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
                              <th scope="col">Nama Aset</th>
                              <th scope="col">Kategori</th>
                              <th scope="col">Dinas</th>
                              {{-- <th scope="col">Detail</th> --}}
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($asets->count() > 0)
                            @foreach ($asets as $key => $item)
                                <tr class="text-center">
                                    <th style="width: 3rem">{{ ( $asets->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->nama_aset ) }}</td>
                                    <td>{{ ( $item->kategoris->jenis ) }}</td>
                                    <td>{{ ( $item->dinas->nama_dinas ) }}</td>
                                    {{-- <td>{{ ( $item->detail ) }}</td> --}}
                                    <td>
                                        <span class="status-badge @if ($item->status_aset === 'Tersedia') text-white bg-primary @else text-white bg-secondary @endif">{{ $item->status_aset }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="{{ url('seeAset/sekda/show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-warning btn-sm" href="{{ url('peminjaman/sekda/create') }}" role="button"><i class="fa-solid fa-file-circle-plus"></i></a>
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
            </div>
            <div class="col d-flex flex-fill mx-2 align-items-center justify-content-end">
                {{ $asets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

