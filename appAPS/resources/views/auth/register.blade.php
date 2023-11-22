@extends('layouts.app')

@section('content')
<div class="container py-4 h-100">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                <!-- <div class="card-header">{{ __('Register') }}</div> -->

                <div class="card-body">
                    <div class="mb-2">
                        <div class="row">
                            <div class="col">
                                <img src="https://bakolkopi.jepara.go.id/wp-content/uploads/sites/93/2022/09/logo-jepara.png" class="img-fluid profile-image-pic me-1" width="37px" alt="profile">
                                <span class="fs-2 fw-bold">{{ __('APS') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h2 class="text-center">{{ __('Daftar Akun') }}</h2>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-2">
                            <label for="nama" class="form-label">{{ __('Nama Lengkap') }}</label>
                            <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required autocomplete="nama" autofocus>
                            
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="nip" class="form-label">{{ __('NIP') }}</label>
                            <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" placeholder="19********" value="{{ old('nip') }}" required autocomplete="nip" autofocus>
                        
                            @error('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="jabatan" class="form-label">{{ __('Jabatan') }}</label>
                            <input id="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" placeholder="Staf" value="{{ old('jabatan') }}" required autocomplete="jabatan" autofocus>
                        
                            @error('jabatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="nama_dinas" class="form-label">{{ __('Asal Dinas') }}</label>
                            <input id="nama_dinas" type="text" class="form-control @error('asal_dinas') is-invalid @enderror" name="nama_dinas" placeholder="Dinas Sosial" value="{{ old('nama_dinas') }}" required autocomplete="nama_dinas" autofocus>
                        
                            @error('nama_dinas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="telp" class="form-label">{{ __('No. Telepon') }}</label>
                            <input id="telp" type="text" class="form-control @error('telp') is-invalid @enderror" name="telp" placeholder="08**********" value="{{ old('telp') }}" required autocomplete="telp" autofocus>

                            @error('telp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
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

                        <div class="mb-2">
                            <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" placeholder="password" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="row mb-3 mt-4">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-3 w-100 fw-bold">{{ __('Daftar') }}</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="text-center">
                                <div id="emailHelp" class="text-center text-dark">Sudah punya akun? 
                                    <a href="{{ route('login') }}" class="text-blue fw-bold"> {{ __('Login') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
