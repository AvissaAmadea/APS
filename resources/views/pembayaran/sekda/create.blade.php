@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.sekda') }}">Dashboard</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('peminjaman.superadmin.index') }}">Riwayat Peminjaman</a></li> --}}
            <li class="breadcrumb-item active fw-bold" aria-current="page">Form Unggah Bukti Pembayaran</li>
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

        <div class="card card flex-fill border-0 p-2">
            <h6 class="card-header">Informasi Pembayaran</h6>
            <div class="card-body">
                <h6 class=" text-center">Pembayaran dapat dilakukan dengan via transfer ke salah satu nomor rekening berikut ini :</h6>
                <div class="row mb-1">
                    <div class="col-6 text-end">
                        <img src="{{ asset('img/jateng.png') }}" class="img-thumbnail" alt="..." style="width: 25%">
                    </div>
                    <div class="col-6 text-start my-3">
                        <h5 class="fw-bold">1227734117644511</h5>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6 text-end">
                        <img src="{{ asset('img/bri.png') }}" class="img-thumbnail" alt="..." style="width: 25%">
                    </div>
                    <div class="col-6 text-start my-4">
                        <h5 class="fw-bold">1227734117644512</h5>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 text-end">
                        <img src="{{ asset('img/bni.png') }}" class="img-thumbnail" alt="..." style="width: 25%">
                    </div>
                    <div class="col-6 text-start my-2">
                        <h5 class="fw-bold">1227734117644513</h5>
                    </div>
                </div>
                <h6 class=" text-center">Pembayaran dikirim ke salah satu rekening tersebut atas nama :</h6>
                <h5 class="fw-bold  text-center">Pembkab Jepara</h5>
            </div>
        </div>

        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header">Form Unggah Bukti Pembayaran</h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="#" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="user_name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10 text-start mt-2">
                            {{-- <input type="text" readonly class="form-control" id="user_name" name="user_name" value="{{ Auth::user()->nama }}" autofocus> --}}
                            <h6 class="form-control-static">{{ Auth::user()->nama }}</h6>
                        </div>
                        <input type="hidden" class="form-control" id="user_name" name="user_name" value="{{ Auth::user()->nama }}">
                    </div>

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

                    {{-- <div class="form-group row">
                        <label for="sanksi" class="col-sm-2 col-form-label">Nominal Sanksi</label>
                        <div class="col-sm-10">
                            <textarea id="sanksi" name="sanksi" readonly>{{ $sanksi ? $sanksi->sanksi : '' }}</textarea>
                        </div>
                    </div> --}}


                    <div class="form-group mb-2 row" id="bukti_pelunasan">
                        <label for="bukti_pelunasan" class="col-sm-2 col-form-label">Bukti Pelunasan</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('bukti_pelunasan') is-invalid @enderror" id="bukti_pelunasan" name="bukti_pelunasan" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" autofocus>
                            <div class="form-text text-start">Bukti Transfer berformat jpg, jpeg, atau png ukuran max. 2 MB</div>
                            @error('bukti_pelunasan')
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

