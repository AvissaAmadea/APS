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
                <form class="form text-end" method="POST" action="{{ route('user') }}">
                    @csrf

                    <div class="form-group mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required autofocus>
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
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" required autofocus>
                        </div>
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required autofocus>
                        </div>
                        @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="dinas_id" class="form-label">Asal Dinas</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('dinas_id') is-invalid @enderror" type="select" id="dinas_id" name="dinas_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Dinas --</option>
                                @foreach ($dinas as $dinasData)
                                    <option value="{{ $dinasData->id }}" {{ old('dinas_id') == $dinasData->id ? 'selected' : null }}>{{ $dinasData->nama_dinas }}</option>
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
                        <label for="telp" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ old('telp') }}" required autofocus>
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="form-text">
                            - Password minimal terdiri dari 8 karakter <br>
                            - Kombinasi huruf, angka, ataupun simbol <br>
                            <!-- - Setidaknya terdiri atas satu huruf kapital <br> -->
                            - Tidak mengandung spasi
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="role_id" class="form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('role_id') is-invalid @enderror" type="select" id="role_id" name="role_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                @foreach ($role as $roleData)
                                    <option value="{{ $roleData->id }}" {{ old('role_id') == $roleData->id ? 'selected' : null }}>{{ $roleData->name }}</option>
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

