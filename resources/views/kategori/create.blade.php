@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Kelola Kategori') }}</strong></h6>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Tambah Jenis Kategori
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ url('kategori/') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ url('kategori') }}">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" value="{{ old('jenis') }}" required autofocus>
                        </div>
                        @error('jenis')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                        <button type="submit" class="btn btn-success btn-sm float-right mb-0" name="submit">Tambah</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

