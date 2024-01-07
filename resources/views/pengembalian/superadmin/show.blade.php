@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengembalian.superadmin.index') }}">Daftar Pengajuan Pengembalian</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Detail Pengembalian</li>
        </ol>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-1">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Detail Pengembalian
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ route('pengembalian.superadmin.index') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <div class="row justify-content-center float-center">
                    <div class="col-lg-10">
                        <div class="form text-end">
                            <div class="form-group mb-2 row">
                                <label for="kode_pinjam" class="col-md-4 col-form-label">Kode Peminjaman :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="kode_pinjam" name="kode_pinjam" value="{{ $kembali->peminjaman->kode_pinjam }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="nama" class="col-md-4 col-form-label">Peminjam :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama" name="nama" value="{{ $kembali->peminjaman->users->nama }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-md-4 col-form-label">Asal Peminjam :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $kembali->peminjaman->users->dinas->nama_dinas }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="nama_aset" class="col-md-4 col-form-label">Nama Aset :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama_aset" name="nama_aset" value="{{ $kembali->peminjaman->asets->nama_aset }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="kategori_id" class="col-md-4 col-form-label">Kategori :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="kategori_id" name="kategori_id" value="{{ $kembali->peminjaman->asets->kategoris->jenis }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-md-4 col-form-label">Asal Aset :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $kembali->peminjaman->asets->dinas->nama_dinas }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="tgl_pinjam" class="col-md-4 col-form-label">Waktu Pinjam :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="tgl_pinjam" name="tgl_pinjam" value="{{ $tgl_pinjam_date }} {{ $tgl_pinjam_time }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="tgl_kembali" class="col-md-4 col-form-label">Waktu Kembali :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="tgl_kembali" name="tgl_kembali" value="{{ $tgl_kembali_date }} {{ $tgl_kembali_time }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="tujuan" class="col-md-4 col-form-label">Keperluan :</label>
                                <div class="col-md-8">
                                    <textarea readonly class="form-control-plaintext fw-bold" id="tujuan" name="tujuan" style="text-align: justify; height: auto; min-height: 30px;">{{ $kembali->peminjaman->tujuan }}</textarea>
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="rusak" class="col-md-4 col-form-label">Rusak :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="rusak" name="rusak" value="{{ $kembali->rusak }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="hilang" class="col-md-4 col-form-label">Hilang :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="hilang" name="hilang" value="{{ $kembali->hilang }}">
                                </div>
                            </div>

                            @if($kembali->rusak === 'Ya' && $kembali->hilang === 'Tidak')
                                <div class="form-group mb-2 row">
                                    <label for="ket_rusak" class="col-md-4 col-form-label">Keterangan Rusak :</label>
                                    <div class="col-md-8">
                                        <textarea readonly class="form-control-plaintext fw-bold" id="ket_rusak" name="ket_rusak" style="text-align: justify; height: auto; min-height: 30px;">{{ $kembali->ket_rusak }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label for="ket_hilang" class="col-md-4 col-form-label">Keterangan Hilang :</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="ket_hilang" name="ket_hilang" value="-">
                                    </div>
                                </div>
                            @elseif($kembali->rusak === 'Tidak' && $kembali->hilang === 'Tidak')
                                <div class="form-group mb-2 row">
                                    <label for="ket_rusak" class="col-md-4 col-form-label">Keterangan Rusak :</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="ket_rusak" name="ket_rusak" value="-">
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label for="ket_hilang" class="col-md-4 col-form-label">Keterangan Hilang :</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="ket_hilang" name="ket_hilang" value="-">
                                    </div>
                                </div>
                            @else
                                <div class="form-group mb-2 row">
                                    <label for="ket_rusak" class="col-md-4 col-form-label">Keterangan Rusak :</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="ket_rusak" name="ket_rusak" value="-">
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label for="ket_hilang" class="col-md-4 col-form-label">Keterangan Hilang :</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="ket_hilang" name="ket_hilang" value="-">
                                    </div>
                                </div>
                            @endif


                            <div class="form-group mb-2 row">
                                <label for="bukti" class="col-sm-4 col-form-label">Bukti Rusak/Hilang : </label>
                                <div class="col-sm-8 text-start mt-2">
                                    @if($kembali->bukti)
                                        @php
                                            $extension = pathinfo($kembali->bukti, PATHINFO_EXTENSION);
                                            $isPDF = $extension === 'pdf';
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                            $fileName = pathinfo($kembali->bukti, PATHINFO_FILENAME);
                                            $filePath = 'uploads/' . $kembali->bukti;
                                        @endphp

                                        @if($isPDF)
                                            <a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }} (PDF)</a>
                                        @elseif($isImage)
                                            {{-- <a href="{{ asset($filePath) }}" target="_blank">
                                                <img src="{{ asset($filePath) }}" alt="Surat Peminjaman" style="max-width: 100%">
                                            </a> --}}
                                            <a href="{{ asset($filePath) }}" target="_blank">
                                                {{ $fileName }} (Lihat gambar)
                                            </a>
                                        @else
                                            <a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }}</a>
                                        @endif
                                    @else
                                        <strong><p>Tidak ada file bukti rusak/hilang terlampir.</p></strong>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="status_kembali" class="col-md-4 col-form-label">Status :</label>
                                <div class="col-auto mt-1">
                                    <span class="status-badge @if ($kembali->status_kembali === 'Menunggu Verifikasi') text-black bg-warning @elseif ($kembali->status_kembali === 'Diterima') text-white bg-success @elseif ($kembali->status_kembali === 'Menunggu Pembayaran') text-white bg-primary @else text-white bg-danger @endif">{{ $kembali->status_kembali }}</span>
                                </div>
                            </div>

                            @if($kembali->rusak === 'Ya' || $kembali->hilang === 'Ya')
                                <div class="form-group mb-3 row">
                                    <label for="sanksi" class="col-md-4 col-form-label">Nominal Sanksi</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control @error('sanksi') is-invalid @enderror" id="sanksi" name="sanksi" value="{{ old('sanksi') }}" autofocus>
                                        @error('sanksi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group mb-3 row">
                                    <label for="sanksi" class="col-md-4 col-form-label">Nominal Sanksi</label>
                                    <div class="col-md-8">
                                        <input type="text" readonly class="form-control-plaintext fw-bold" id="sanksi" name="sanksi" value="-">
                                    </div>
                                </div>
                            @endif

                            @if ($kembali->rusak === 'Ya' || $kembali->hilang === 'Ya')
                                <div class="form-group mb-2 row">
                                    <label for="status_kembali" class="col-md-4 col-form-label">Verifikasi :</label>
                                    <div class="col-md-8 text-start">
                                        <form action="{{ route('peminjaman.verifikasi', ['id' => $kembali->id]) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-2 row">
                                                <div class="col-md-12">
                                                    {{-- <button type="submit" name="status_kembali" value="Diterima" class="btn btn-sm btn-success">Diterima</button> --}}
                                                    <button type="submit" name="status_kembali" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                                    <button type="submit" name="status_kembali" value="Menunggu Pembayaran" class="btn btn-sm btn-primary">Menunggu Pembayaran</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="form-group mb-2 row">
                                    <label for="status_kembali" class="col-md-4 col-form-label">Verifikasi :</label>
                                    <div class="col-md-8 text-start">
                                        <form action="{{ route('peminjaman.verifikasi', ['id' => $kembali->id]) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-2 row">
                                                <div class="col-md-12">
                                                    <button type="submit" name="status_kembali" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                                    <button type="submit" name="status_kembali" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                                    {{-- <button type="submit" name="status_kembali" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button> --}}
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection