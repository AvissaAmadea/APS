@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Kelola Pengguna') }}</strong></h6>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @endif
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Data Pengguna Terhapus
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ url('user/') }}" role="button"><i class="fa-solid fa-chevron-left pe-1"></i>Back</a>
                    <a class="btn btn-danger btn-sm" href="{{ url('user/delete') }}" role="button"><i class="fa-solid fa-trash pe-1"></i>All Delete</a>
                    <a class="btn btn-success btn-sm" href="{{ url('user/restore') }}" role="button"><i class="fa-solid fa-rotate-left pe-1"></i>All Restore</a>
                    <form class="form-search" method="GET" action="#">
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
                            <a class="btn btn-secondary btn-sm" href="{{ url('user/') }}" role="button"><i class="fa-solid fa-chevron-left pe-1"></i>Back</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('user/delete') }}" role="button"><i class="fa-solid fa-trash pe-1"></i>All Delete</a>
                            <a class="btn btn-success btn-sm" href="{{ url('user/restore') }}" role="button"><i class="fa-solid fa-rotate-left pe-1"></i>All Restore</a>
                        </div>
                        <form class="form-search" method="GET" action="#">
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
                              <th scope="col">Nama</th>
                              <th scope="col">Dinas</th>
                              <th scope="col">Role</th>
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($users->count() > 0)
                            @foreach ($users as $key => $item)
                                <tr class="text-center">
                                    <th>{{ ( $users->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->nama ) }}</td>
                                    <td>{{ ( $item->dinas->nama_dinas ) }}</td>
                                    <td>{{ ( $item->roles->name ) }}</td>
                                    <td>
                                        @if($item->trashed())
                                            <div class="p-0 my-0 bg-danger text-white">Inactive</div>
                                        @else
                                            <div class="p-0 my-0 bg-primary text-white">Active</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-success btn-sm" href="{{ url('user/restore/', $item->id) }}" role="button"><i class="fa-solid fa-rotate-left"></i></a>
                                        <a class="btn btn-danger btn-sm" href="{{ url('user/delete/', $item->id) }}" role="button" onclick="return confirm('Yakin akan hapus data permanen?')"><i class="fa-solid fa-x"></i></a>
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
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

