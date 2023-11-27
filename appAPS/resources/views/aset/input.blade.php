@extends('sidebar.superadmin')

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
                        <h4>{{ __('Tambah Aset') }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body mx-2">
                <form class="form text-end" method="GET" action="#">
                    <div class="form-group mb-3 row">
                        <label for="inputAset" class="col-sm-2 col-form-label">Nama Aset</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAset" name="namaAset">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputJenis" class="col-sm-2 col-form-label">Jenis Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputJenis" name="jenis">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputAsalDinas" class="col-sm-2 col-form-label">Asal Dinas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAsalDinas" name="asalDinas">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputKeterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="inputKeterangan" rows="3" name="ketAset"></textarea>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputStatusAset" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" type="select" id="inputStatusAset">
                                <option selected>-- Status --</option>
                                <option value="1">Tersedia</option>
                                <option value="2">Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-sm float-right mt-2" name="submit">Tambah</button>
                    </div>
                        
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

