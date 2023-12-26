@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengembalian.superadmin.riwayat') }}">Riwayat Peminjaman</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Detail Riwayat Peminjaman</li>
        </ol>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-1">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Detail Riwayat Peminjaman
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ route('pengembalian.superadmin.riwayat') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-9">
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
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="tgl_pinjam" name="tgl_pinjam" value="{{ $kembali->peminjaman->tgl_pinjam }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="tgl_kembali" class="col-md-4 col-form-label">Waktu Kembali :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="tgl_kembali" name="tgl_kembali" value="{{ $kembali->peminjaman->tgl_kembali }}">
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

                            @if($kembali->rusak === 'Ya' || $kembali->hilang === 'Ya')
                                <div class="form-group mb-2 row">
                                    <label for="ket_rusak" class="col-md-4 col-form-label">Keterangan Rusak :</label>
                                    <div class="col-md-8">
                                        <textarea readonly class="form-control-plaintext fw-bold" id="ket_rusak" name="ket_rusak" style="text-align: justify; height: auto; min-height: 30px;">{{ $kembali->ket_rusak }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group mb-2 row">
                                    <label for="ket_hilang" class="col-md-4 col-form-label">Keterangan Hilang :</label>
                                    <div class="col-md-8">
                                        <textarea readonly class="form-control-plaintext fw-bold" id="ket_hilang" name="ket_hilang" style="text-align: justify; height: auto; min-height: 30px;">{{ $kembali->ket_hilang }}</textarea>
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
                                            <a href="{{ asset($filePath) }}" target="_blank">
                                                <img src="{{ asset($filePath) }}" alt="Surat Peminjaman" style="max-width: 100%">
                                            </a>
                                        @else
                                            <a href="{{ asset($filePath) }}" target="_blank">{{ $fileName }}</a>
                                        @endif
                                    @else
                                        <p>Tidak ada file surat peminjaman terlampir.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="status_kembali" class="col-md-4 col-form-label">Status :</label>
                                <div class="col-auto mt-1">
                                    <span class="status-badge @if ($kembali->status_kembali === 'Menunggu Verifikasi') text-black bg-warning @elseif ($kembali->status_kembali === 'Diterima') text-white bg-success @elseif ($kembali->status_kembali === 'Menunggu Pembayaran') text-white bg-primary @else text-white bg-danger @endif">{{ $kembali->status_kembali }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- <div class="col-md-8 offset-md-2">
                        <table class="table table-bordered table-striped-columns">
                            <tbody>
                                <tr>
                                    <td style="width: 35%">Nama Pengguna</td>
                                    <th>{{ $user->nama }}</th>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <th>{{ $user->nip }}</th>
                                </tr>
                                <tr>
                                    <td>Dinas</td>
                                    <th>{{ $user->dinas->nama_dinas }}</th>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <th>{{ $user->jabatan }}</th>
                                </tr>
                                <tr>
                                    <td>No. Telepon</td>
                                    <th>{{ $user->telp }}</th>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <th>{{ $user->email }}</th>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <th>{{ $user->roles->name }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
