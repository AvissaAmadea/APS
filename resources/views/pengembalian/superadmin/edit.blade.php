@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengembalian.superadmin.index') }}">Riwayat Pengembalian</a></li>
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
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Edit Pengajuan Peminjaman
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ route('pengembalian.superadmin.index') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('pengembalian.update', $pengembalian->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="kode_pinjam" class="col-sm-3 col-form-label">Kode Peminjaman</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control @error('kode_pinjam') is-invalid @enderror" id="kode_pinjam" name="kode_pinjam" value="{{ $pengembalian->peminjaman->kode_pinjam }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="user_name" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control" id="user_name" name="user_name" value="{{ $pengembalian->peminjaman->users->nama }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-1 row">
                        <label for="rusak" class="col-sm-3 col-form-label">Adakah Kerusakan?</label>
                        <div class="col-sm-9 text-start mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rusak" id="rusakYa" value="Ya" onclick="showKeteranganRusakBukti()" {{ $pengembalian->rusak == 'Ya' ? 'checked' : '' }}>
                                <label class="form-check-label" for="rusakYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rusak" id="rusakTidak" value="Tidak" onclick="hideKeteranganRusakBukti()" {{ $pengembalian->rusak == 'Tidak' ? 'checked' : '' }}>
                                <label class="form-check-label" for="rusakTidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="hilang" class="col-sm-3 col-form-label">Adakah Kehilangan?</label>
                        <div class="col-sm-9 text-start mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hilang" id="hilangYa" value="Ya" onclick="showKeteranganHilangBukti()" {{ $pengembalian->hilang == 'Ya' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hilangYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hilang" id="hilangTidak" value="Tidak" onclick="hideKeteranganHilangBukti()" {{ $pengembalian->hilang == 'Tidak' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hilangTidak">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="keteranganRusak" style="display: none;">
                        <label for="ket_rusak" class="col-sm-3 col-form-label">Keterangan Rusak</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('ket_rusak') is-invalid @enderror" id="ket_rusak" name="ket_rusak" value="{{ $pengembalian->ket_rusak }}" autofocus>
                            @error('ket_rusak')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="keteranganHilang" style="display: none;">
                        <label for="ket_hilang" class="col-sm-3 col-form-label">Keterangan Hilang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('ket_hilang') is-invalid @enderror" id="ket_hilang" name="ket_hilang" value="{{ $pengembalian->ket_hilang }}" autofocus>
                            @error('ket_hilang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="bukti" class="col-sm-3 col-form-label">Bukti Rusak/Hilang</label>
                        <div class="col-sm-9 text-start mt-2">
                            @if($pengembalian->bukti)
                                @php
                                    $extension = pathinfo($kembali->bukti, PATHINFO_EXTENSION);
                                    $isPDF = $extension === 'pdf';
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                    $fileName = pathinfo($pengembalian->bukti, PATHINFO_FILENAME);
                                    $filePath = 'uploads/' . $pengembalian->bukti;
                                @endphp

                                @if($isPDF)
                                    <a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }} (PDF)</a>
                                @elseif($isImage)
                                    <a href="{{ asset($filePath) }}" target="_blank">
                                        <img src="{{ asset($filePath) }}" alt="Bukti Rusak/Hilang" style="max-width: 100%">
                                    </a>
                                @else
                                    <a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }}</a>
                                @endif
                            @else
                                <p>Tidak ada file surat peminjaman terlampir.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-2 row" id="bukti" style="display: none;">
                        <label for="bukti" class="col-sm-3 col-form-label">Ubah Bukti</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" autofocus>
                            <div class="form-text text-start">Dapat berupa foto bagian kerusakan atau surat kehilangan</div>
                            @error('bukti')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="status_kembali" class="col-sm-3 col-form-label">Status Pengembalian</label>
                        <div class="col-sm-9 text-start mt-1">
                            <!-- Display current file name -->
                            {{-- <h6>{{ $peminjaman->status_pinjam }}</h6> --}}
                            <span class="status-badge @if ($pengembalian->status_kembali === 'Menunggu Verifikasi') text-black bg-warning @elseif ($pengembalian->status_kembali === 'Diterima') text-white bg-success @elseif ($pengembalian->status_kembali === 'Menunggu Pembayaran') text-white bg-primary @else text-white bg-danger @endif">{{ $pengembalian->status_kembali }}</span>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="status_kembali" class="col-sm-3 col-form-label">Ubah Status Pengembalian</label>
                        <div class="col-sm-9 text-start">
                            <form action="{{ route('peminjaman.verifikasi', ['id' => $pengembalian->id]) }}" method="POST">
                                @csrf
                                <div class="form-group mb-2 row">
                                    <div class="col-md-12">
                                        @if($pengembalian->status_kembali === 'Diterima')
                                            <button type="submit" name="status_kembali" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button>
                                            <button type="submit" name="status_kembali" value="Menunggu Pembayaran" class="btn btn-sm btn-primary">Menunggu Pembayaran</button>
                                            <button type="submit" name="status_kembali" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                        @elseif($pengembalian->status_kembali === 'Menunggu Verifikasi')
                                            <button type="submit" name="status_kembali" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                            <button type="submit" name="status_kembali" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                            <button type="submit" name="status_kembali" value="Menunggu Pembayaran" class="btn btn-sm btn-primary">Menunggu Pembayaran</button>
                                        @elseif($pengembalian->status_kembali === 'Ditolak')
                                            <button type="submit" name="status_kembali" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button>
                                            <button type="submit" name="status_kembali" value="Menunggu Pembayaran" class="btn btn-sm btn-primary">Menunggu Pembayaran</button>
                                            <button type="submit" name="status_kembali" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                        @elseif($pengembalian->status_kembali === 'Menunggu Pembayaran')
                                            <button type="submit" name="status_kembali" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                            <button type="submit" name="status_kembali" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                            <button type="submit" name="status_kembali" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm float-end mb-0 mt-2" name="submit">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

