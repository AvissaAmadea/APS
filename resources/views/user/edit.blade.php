@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h6><strong>{{ __('Kelola Pengguna') }}</strong></h6>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col text-center">
                        <h5>{{ __('Edit Pengguna') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('user') }}">
                    @csrf

                    <div class="form-group mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $users->nama }}" required autofocus>
                        </div>
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ $users->nip }}" required autofocus>
                        </div>
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="dinas_id" class="col-sm-2 col-form-label">Dinas</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('dinas_id') is-invalid @enderror" type="select" id="dinas_id" name="dinas_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Dinas --</option>
                                @foreach ($users as $user)
                                    @foreach ($dinas as $dinasData)
                                        <option value="{{ $dinasData->id }}" {{ $user->dinas_id == $dinasData->id ? 'selected' : null }}>{{ $dinasData->nama_dinas }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('dinas_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ $users->jabatan }}" required autofocus>
                        </div>
                        @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="telp" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ $users->telp }}" required autofocus>
                        </div>
                        @error('telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $users->email }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password" readonly>
                            <div class="form-text text-start">
                                - Password minimal terdiri dari 8 karakter <br>
                                - Kombinasi huruf, angka, ataupun simbol <br>
                                <!-- - Setidaknya terdiri atas satu huruf kapital <br> -->
                                - Tidak mengandung spasi
                            </div>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="role_id" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('role_id') is-invalid @enderror" type="select" id="role_id" name="role_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                @foreach ($roles as $roleData)
                                    <option value="{{ $roleData->id }}" {{ $users->role_id == $roleData->id ? 'selected' : null }}>{{ $roleData->name }}</option>
                                @endforeach
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

