@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h6><strong>{{ __('Kelola Pengguna') }}</strong></h6>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-header">
                <h6>Data Pengguna</h6>
            </div>
            <div class="card-title">
                <div class="row">
                    <div class="col text-center">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-title mb-2 mx-2">
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success btn-sm" href="{{ url('user/create') }}" role="button" style="width: fit-content">{{ __('+ Tambah') }}</a>
                            <form class="form-search d-flex" method="GET" action="#">
                                <div class="input-group">
                                    <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 20rem; height: 33px"/>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-2">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Nama</th>
                              {{-- <th scope="col">NIP</th>
                              <th scope="col">Jabatan</th> --}}
                              <th scope="col">Dinas</th>
                              {{-- <th scope="col">Email</th> --}}
                              <th scope="col">No. Telepon</th>
                              <th scope="col">Role</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $item)
                            <tr class="text-center">
                                <th>{{ ( $loop->iteration ) }}</th>
                                <td>{{ ( $item->nama ) }}</td>
                                {{-- <td>{{ ( $item->nip ) }}</td>
                                <td>{{ ( $item->jabatan ) }}</td> --}}
                                <td>{{ ( $item->dinas->nama_dinas ) }}</td>
                                {{-- <td>{{ ( $item->email ) }}</td> --}}
                                <td>{{ ( $item->telp ) }}</td>
                                <td>{{ ( $item->roles->name ) }}</td>
                                <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ url('user/show') }}" role="button"><i class="fa-solid fa-circle-info"></i></a>
                                <a class="btn btn-warning btn-sm" href="{{ url('user/edit/'.$item->id) }}" role="button"><i class="fa-solid fa-pen"></i></a>
                                <a class="btn btn-danger btn-sm" href="{{ url('user/delete') }}" role="button"><i class="fa-solid fa-trash-can"></i></a>
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

