@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h5>{{ __('Kelola Aset') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col mt-1">
                        <h4>{{ __('Lihat Aset') }}</h4>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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
                              <th class="col">No.</th>
                              <th class="col-2">Nama Aset</th>
                              <th class="col">Kategori</th>
                              <th class="col">Asal Dinas</th>
                              <th class="col">Kuantitas</th>
                              <th class="col-4">Keterangan</th>
                              <th class="col">Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr class="text-center">
                              <th>{{ __('1') }}</th>
                              <td>{{ __('Ruang Rapat') }}</td>
                              <td>{{ __('Ruang') }}</td>
                              <td>{{ __('Dinas Komunikasi dan Informatika') }}</td>
                              <td>{{ __('1') }}</td>
                              <td>{{ __('Ruang Rapat berkapasitas hingga 30 orang. Alamat di Gedung OPD Bersama, Jl. Kartini No.1, Panggang I, Panggang, Kec. Jepara, Kabupaten Jepara, Jawa Tengah') }}</td>
                              <td><span class="badge text-bg-primary">{{ __('Tersedia') }}</span></td> <!-- dikasih kondisi -->
                          </tr>
                          
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

