@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h5>{{ __('Dashboard Super Admin') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col mt-1">
                        <h4>{{ __('Riwayat Peminjaman') }}</h4>
                    </div>
                    <div class="col">
                        <form class="form-search d-flex" method="GET" action="#" style="float: right">
                            <div class="input-group">
                                    <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 40cm"/>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </form>    
                    </div>
                </div>
            </div>
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-2">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">{{ __('No.') }}</th>
                              <th scope="col">{{ __('Nama Aset') }}</th>
                              <th scope="col">{{ __('Asal Dinas') }}</th>
                              <th scope="col">{{ __('Waktu Pinjam') }}</th>
                              <th scope="col">{{ __('Waktu Kembali') }}</th>
                              <th scope="col">{{ __('Status') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <th class="text-center" scope="row">{{ __('1') }}</th>
                              <td>{{ __('Aset') }}</td>
                              <td>{{ __('Dinas Sosial') }}</td>
                              <td>{{ __('10-03-2024') }}</td>
                              <td>{{ __('15-03-2024') }}</td>
                              <td class="text-center">{{ __('Status') }}</td>
                          </tr>
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

