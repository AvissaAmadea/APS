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
                        <h4>{{ __('Kelola Data Pengguna') }}</h4>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success" href="#" role="button"><i class="fa-solid fa-plus pe-2"></i>{{ __('Tambah') }}</a>
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
                          <tr class="text-center">
                              <th>{{ __('1') }}</th>
                              <td>{{ __('Person Person') }}</td>
                              <td>{{ __('199719971997') }}</td>
                              <td>{{ __('Non-ASN') }}</td>
                              <td>{{ __('Dinas Komunikasi dan Informasi') }}</td>
                              <td>{{ __('person1@gmail.com') }}</td>
                              <td>{{ __('089123456789') }}</td>
                              <td>{{ __('Sekda') }}</td>
                              <td class="text-center">
                                <!-- <a class="btn btn-info btn-sm" href="#" role="button"><i class="fa-solid fa-info pe-2"></i>{{ __('Detail') }}</a> -->
                                <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-pen"></i></a>
                                <a class="btn btn-danger btn-sm" href="#" role="button"><i class="fa-solid fa-trash-can"></i></a>
                              </td>
                          </tr>
                          
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

