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
                        <h4>{{ __('Tambah Pengguna') }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body mx-2">
                <form class="form text-end" method="GET" action="#">
                    <div class="form-group mb-3 row">
                        <label for="inputUser" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputUser" name="namaUser">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputNip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNip" name="nip">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputJabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputJabatan" name="jabatan">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputDinas" class="col-sm-2 col-form-label">Dinas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputDinas" name="dinas">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="email">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputTelp" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputTelp" name="telp">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputRole" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" type="select" id="inputRole">
                                <option selected>-- Roles --</option>
                                <option value="1">Sekretaris Daerah</option>
                                <option value="2">OPD</option>
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

