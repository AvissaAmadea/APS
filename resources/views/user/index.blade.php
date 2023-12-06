@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h5>{{ __('Kelola Pengguna') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col mt-1">
                        <h6>{{ __('Data Pengguna') }}</h6>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success" href="{{ url('user/create') }}" role="button"><i class="fa-solid fa-plus pe-2"></i>{{ __('Tambah') }}</a>
                            <form class="form-search d-flex" method="GET" action="#">
                                <div class="input-group">
                                    <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 7cm;"/>
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
                              <th scope="col">NIP</th>
                              <th scope="col">Jabatan</th>
                              <th scope="col">Dinas</th>
                              <th scope="col">Email</th>
                              <th scope="col">No. Telepon</th>
                              <th scope="col">Role</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $item)
                            <tr class="text-center">
                                <th>{{ ( $item->id ) }}</th>
                                <td>{{ ( $item->nama ) }}</td>
                                <td>{{ ( $item->nip ) }}</td>
                                <td>{{ ( $item->jabatan ) }}</td>
                                <td>{{ ( $item->dinas_id ) }}</td>
                                <td>{{ ( $item->email ) }}</td>
                                <td>{{ ( $item->telp ) }}</td>
                                <td>{{ ( $item->role_id ) }}</td>
                                <td class="text-center">
                                <!-- <a class="btn btn-info btn-sm" href="#" role="button"><i class="fa-solid fa-info pe-2"></i>{{ __('Detail') }}</a> -->
                                <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-pen"></i></a>
                                <a class="btn btn-danger btn-sm" href="#" role="button"><i class="fa-solid fa-trash-can"></i></a>
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

