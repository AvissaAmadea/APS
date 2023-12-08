@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h6><strong>{{ __('Kelola Pengguna') }}</strong></h6>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header">Data Pengguna</h6>
            <div class="card-title my-3 mx-2">
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success btn-sm" href="{{ url('user/create') }}" role="button" style="width: fit-content">{{ __('+ Tambah') }}</a>
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
                              <th scope="col">Nama</th>
                              <th scope="col">Dinas</th>
                              <th scope="col">Role</th>
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $item)
                            <tr class="text-center">
                                <th>{{ ( $loop->iteration ) }}</th>
                                <td>{{ ( $item->nama ) }}</td>
                                <td>{{ ( $item->dinas->nama_dinas ) }}</td>
                                <td>{{ ( $item->roles->name ) }}</td>
                                <td>
                                    @if($item->trashed())
                                        <div class="p-0 mb-0 bg-danger text-white">Inactive</div>
                                    @else
                                        <div class="p-0 mb-0 bg-primary text-white">Active</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('user.show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('user.edit', $item->id) }}" role="button"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin akan hapus data ini?')">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
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

