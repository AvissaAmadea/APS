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
                        <h6>{{ __('Tambah Pengguna') }}</h6>
                    </div>
                </div>
            </div>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ url('user') }}">
                    @csrf
                    <div class="form-group mb-3 row">
                        <label for="inputUser" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputUser" name="nama" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputNip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNip" name="nip" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputJabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputJabatan" name="jabatan" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="dinas_id" class="form-label">{{ __('Asal Dinas') }}</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('dinas_id') is-invalid @enderror" type="select" id="dinas_id" name="dinas_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Dinas --</option>
                                @foreach ($dinas as $dinasData)
                                    <option value="{{ $dinasData->id }}">{{ $dinasData->nama_dinas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="inputTelp" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputTelp" name="telp" required autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="role_id" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" type="select" id="role_id" name="role_id" required autofocus>
                                <option selected>-- Pilih Role --</option>
                                <option value="1">Superadmin</option>
                                <option value="2">Sekretaris Daerah</option>
                                <option value="3">OPD</option>
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

