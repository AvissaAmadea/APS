@extends('layouts.app')

@section('content')
    <div class="container py-5 h-100">
        <div class="row justify-content-center mt-3">
            <div class="col-md-5 mt-4">
                <div class="card" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                    <div class="card-body">
                        <form action="POST" action="{{ route('login')}}">
                        @csrf

                        <div class="mb-2">
                            <div class="row">
                                <div class="col">
                                    <img src="https://bakolkopi.jepara.go.id/wp-content/uploads/sites/93/2022/09/logo-jepara.png" class="img-fluid profile-image-pic me-1" width="40px" alt="profile">
                                    <span class="fs-2 fw-bold">{{ __('APS') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h2 class="text-center">{{ __('Login') }}</h2>
                                </div>
                            </div>
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
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col mt-2">
                                <div class="text-right">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-end">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Lupa Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-3 w-100 fw-bold">{{ __('Login') }}</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="text-center">
                                <div id="emailHelp" class="text-center text-dark">Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-blue fw-bold"> Daftar</a>
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