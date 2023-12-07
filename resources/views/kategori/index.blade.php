@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h6><strong>{{ __('Kelola Kategori') }}</strong></h6>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header">Data Kategori</h6>
            <div class="card-title my-3 mx-2">
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success btn-sm" href="{{ url('kategori/create') }}" role="button" style="width: fit-content">{{ __('+ Tambah') }}</a>
                            <form class="form-search d-flex" method="GET" action="#">
                                <div class="input-group">
                                    <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 15rem; height: 33px"/>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 d-flex flex-fill mx-2">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Jenis</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($kategori as $item)
                            <tr class="text-center">
                                <th>{{ ( $loop->iteration ) }}</th>
                                <td>{{ ( $item->jenis ) }}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning btn-sm" href="{{ url('kategori/edit/'.$item->id) }}" role="button"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ url('kategori/'.$item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin akan hapus data ini?')">
                                        @method('delete')
                                        @csrf
                                        <a class="btn btn-danger btn-sm" href="{{ url('kategori/delete') }}" role="button"><i class="fa-solid fa-trash-can"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

