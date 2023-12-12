@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Kelola Kategori') }}</strong></h6>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Data Kategori
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-success btn-sm" href="{{ route('kategori.create') }}" role="button" style="width: fit-content"><i class="fa-solid fa-plus pe-2"></i>{{ __('Tambah') }}</a>
                    {{-- <a class="btn btn-danger btn-sm" href="{{ url('user/trash') }}" role="button" style="width: fit-content"><i class="fa-solid fa-trash pe-2"></i>{{ __('Trash') }}</a> --}}
                    <form class="form-search d-flex" method="GET" action="#">
                        <div class="input-group">
                            <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 15rem; height: 33px"/>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </h6>
            {{-- <div class="card-title my-3 mx-2">
                <div class="row">
                    <div class="col d-flex align-items-center justify-content-between">
                        <div>
                            <a class="btn btn-success btn-sm" href="{{ url('user/create') }}" role="button" style="width: fit-content"><i class="fa-solid fa-plus pe-2"></i>{{ __('Tambah') }}</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('user/trash') }}" role="button" style="width: fit-content"><i class="fa-solid fa-trash pe-2"></i>{{ __('Trash') }}</a>
                        </div>
                        <form class="form-search d-flex" method="GET" action="#">
                            <div class="input-group">
                                <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 15rem; height: 33px"/>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-3">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Jenis Kategori</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($kategoris->count() > 0)
                            @foreach ($kategoris as $key => $item)
                                <tr class="text-center">
                                    <th>{{ ( $kategoris->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->jenis ) }}</td>
                                    <td class="text-center">
                                        {{-- <a class="btn btn-info btn-sm" href="{{ route('kategori.show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a> --}}
                                        <a class="btn btn-warning btn-sm" href="{{ route('kategori.edit', $item->id) }}" role="button"><i class="fa-solid fa-pen"></i></a>
                                        <form action="{{ url('kategori/destroy/', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin akan hapus data ini?')">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-x"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                      </tbody>
                  </table>

                <!-- </div> -->
            </div>
            <div class="col d-flex flex-fill mx-2 align-items-center justify-content-end">
                {{ $kategoris->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

