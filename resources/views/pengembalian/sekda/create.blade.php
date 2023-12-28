@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.sekda') }}">Dashboard</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('peminjaman.superadmin.index') }}">Riwayat Peminjaman</a></li> --}}
            <li class="breadcrumb-item active fw-bold" aria-current="page">Form Pengajuan Pengembalian</li>
        </ol>
    </div>
    <div class="row">
        @if (session('status'))
            <div class="alert alert-primary text-center">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header">Form Pengajuan Pengembalian</h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('pengembalian.sekda.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="kode_pinjam" class="col-sm-2 col-form-label">Kode Peminjaman</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('kode_pinjam') is-invalid @enderror" id="kode_pinjam" name="kode_pinjam" value="{{ old('kode_pinjam') }}" autofocus>
                            @error('kode_pinjam')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="user_name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="user_name" name="user_name" value="{{ Auth::user()->nama }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="rusak" class="col-sm-2 col-form-label">Adakah Kerusakan?</label>
                        <div class="col-sm-10 text-start mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rusak" id="rusakYa" value="Ya" onclick="showKeteranganRusakBukti()">
                                <label class="form-check-label" for="rusakYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rusak" id="rusakTidak" value="Tidak" onclick="hideKeteranganRusakBukti()">
                                <label class="form-check-label" for="rusakTidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="hilang" class="col-sm-2 col-form-label">Adakah Kehilangan?</label>
                        <div class="col-sm-10 text-start mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hilang" id="hilangYa" value="Ya" onclick="showKeteranganHilangBukti()">
                                <label class="form-check-label" for="hilangYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hilang" id="hilangTidak" value="Tidak" onclick="hideKeteranganHilangBukti()">
                                <label class="form-check-label" for="hilangTidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="keteranganRusak" style="display: none;">
                        <label for="ket_rusak" class="col-sm-2 col-form-label">Keterangan Rusak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('ket_rusak') is-invalid @enderror" id="ket_rusak" name="ket_rusak" value="{{ old('ket_rusak') }}" autofocus>
                            @error('ket_rusak')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="keteranganHilang" style="display: none;">
                        <label for="ket_hilang" class="col-sm-2 col-form-label">Keterangan Hilang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('ket_hilang') is-invalid @enderror" id="ket_hilang" name="ket_hilang" value="{{ old('ket_hilang') }}" autofocus>
                            @error('ket_hilang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="bukti" style="display: none;">
                        <label for="bukti" class="col-sm-2 col-form-label">Bukti Rusak/Hilang</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" value="{{ old('bukti') }}" autofocus>
                            <div class="form-text text-start">Dapat berupa foto bagian kerusakan atau surat kehilangan ukuran max. 2 MB</div>
                            @error('bukti')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm float-right mb-0 mt-2" name="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

