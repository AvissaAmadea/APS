@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Kelola Pengguna') }}</strong></h6>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-1">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Detail Pengguna
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-warning btn-sm" href="{{ url('user/edit/'.$user->id) }}" role="button" style="width: fit-content">Edit</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-8 offset-md-3">
                        <div class="form text-end">
                            <div class="form-group mb-2 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama" name="nama" value="{{ $user->nama }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="nip" class="col-sm-2 col-form-label">NIP :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nip" name="nip" value="{{ $user->nip }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-sm-2 col-form-label">Dinas :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $user->dinas->nama_dinas }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="jabatan" name="jabatan" value="{{ $user->jabatan }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="telp" class="col-sm-2 col-form-label">No. Telepon :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="telp" name="telp" value="{{ $user->telp }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="email" class="col-sm-2 col-form-label">Email :</label>
                                <div class="col-sm-10">
                                    <input type="email" readonly class="form-control-plaintext fw-bold" id="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="role_id" class="col-sm-2 col-form-label">Role :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="role_id" name="role_id" value="{{ $user->roles->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- <div class="col-md-8 offset-md-2">
                        <table class="table table-bordered table-striped-columns">
                            <tbody>
                                <tr>
                                    <td style="width: 35%">Nama Pengguna</td>
                                    <th>{{ $user->nama }}</th>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <th>{{ $user->nip }}</th>
                                </tr>
                                <tr>
                                    <td>Dinas</td>
                                    <th>{{ $user->dinas->nama_dinas }}</th>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <th>{{ $user->jabatan }}</th>
                                </tr>
                                <tr>
                                    <td>No. Telepon</td>
                                    <th>{{ $user->telp }}</th>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <th>{{ $user->email }}</th>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <th>{{ $user->roles->name }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}


            </div>
        </div>
    </div>
</div>
@endsection

