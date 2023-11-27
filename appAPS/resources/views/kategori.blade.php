@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h5>{{ __('Kelola Kategori') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col mt-1">
                        <h4>{{ __('Kelola Kategori Aset') }}</h4>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-success" href="#" role="button" style="max-width: 7.8cm;"><i class="fa-solid fa-plus pe-2"></i>{{ __('Tambah') }}</a>
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
                              <th scope="col-md-1">{{ __('No.') }}</th>
                              <th scope="col-md-6">{{ __('Jenis Kategori') }}</th>
                              <th scope="col-md-5">{{ __('Aksi') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr class="text-center">
                              <th>{{ __('1') }}</th>
                              <td>{{ __('Ruang') }}</td>
                              <td class="text-center">
                                <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-pen pe-2"></i>{{ __('Edit') }}</a>
                                <a class="btn btn-danger btn-sm" href="#" role="button"><i class="fa-solid fa-trash-can pe-2"></i>{{ __('Hapus') }}</a>
                              </td>
                          </tr>
                          <tr class="text-center">
                            <th>{{ __('2') }}</th>
                            <td>{{ __('Kendaraan') }}</td>
                            <td class="text-center">
                              <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-pen pe-2"></i>{{ __('Edit') }}</a>
                              <a class="btn btn-danger btn-sm" href="#" role="button"><i class="fa-solid fa-trash-can pe-2"></i>{{ __('Hapus') }}</a>
                            </td>
                          </tr>
                          <tr class="text-center">
                            <th>{{ __('3') }}</th>
                            <td>{{ __('Barang') }}</td>
                            <td class="text-center">
                              <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-pen pe-2"></i>{{ __('Edit') }}</a>
                              <a class="btn btn-danger btn-sm" href="#" role="button"><i class="fa-solid fa-trash-can pe-2"></i>{{ __('Hapus') }}</a>
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

