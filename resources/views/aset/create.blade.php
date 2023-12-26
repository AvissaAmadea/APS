@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Kelola Aset</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Tambah Aset</li>
        </ol>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Tambah Aset
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ route('aset.index') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('aset.index') }}">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="nama_aset" class="col-sm-2 col-form-label">Nama Aset</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_aset') is-invalid @enderror" id="nama_aset" name="nama_aset" value="{{ old('nama_aset') }}" required autofocus>
                        </div>
                        @error('nama_aset')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="kategori_id" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('kategori_id') is-invalid @enderror" type="select" id="kategori_id" name="kategori_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategoriData)
                                    <option value="{{ $kategoriData->id }}" {{ old('kategori_id') == $kategoriData->id ? 'selected' : null }}>{{ $kategoriData->jenis }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="dinas_id" class="col-sm-2 col-form-label">Dinas</label>
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

                    <div class="form-group mb-2 row">
                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                        <div class="col-sm-10">
                            {{-- <input type="text" class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" value="{{ old('detail') }}" required autofocus> --}}
                            <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" name="detail" value="{{ old('detail') }}" required autofocus rows="5"></textarea>
                        </div>
                        @error('detail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="status_aset" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('status_aset') is-invalid @enderror" id="status_aset" name="status_aset" required autofocus>
                                <option value="" selected disabled>-- Pilih Status --</option>
                                @foreach (['Tersedia', 'Tidak Tersedia'] as $statuses)
                                    <option value="{{ $statuses }}">{{ $statuses }}</option>
                                @endforeach
                            </select>
                            @error('status_aset')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                        <button type="submit" class="btn btn-success btn-sm float-right mb-0 mt-2" name="submit">Tambah</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

