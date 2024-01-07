@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.sekda') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('peminjaman.sekda.index') }}">Daftar Pengajuan Peminjaman</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Detail Peminjaman</li>
        </ol>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-1">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Detail Peminjaman
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ route('peminjaman.sekda.index') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <div class="form text-end">
                            <div class="form-group mb-2 row">
                                <label for="kode_pinjam" class="col-md-4 col-form-label">Kode Peminjaman :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="kode_pinjam" name="kode_pinjam" value="{{ $pinjams->kode_pinjam }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="nama_aset" class="col-md-4 col-form-label">Peminjam :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama_aset" name="nama_aset" value="{{ $pinjams->users->nama }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-md-4 col-form-label">Asal Peminjam :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $pinjams->users->dinas->nama_dinas }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="nama_aset" class="col-md-4 col-form-label">Nama Aset :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama_aset" name="nama_aset" value="{{ $pinjams->asets->nama_aset }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="kategori_id" class="col-md-4 col-form-label">Kategori :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="kategori_id" name="kategori_id" value="{{ $pinjams->asets->kategoris->jenis }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-md-4 col-form-label">Asal Aset :</label>
                                <div class="col-md-8">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $pinjams->asets->dinas->nama_dinas }}">
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
                                    <textarea class="form-control-plaintext fw-bold" id="tujuan" name="tujuan" style="text-align: justify; height: auto; min-height: 30px;">{{ $pinjams->tujuan }}</textarea>
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="surat_pinjam" class="col-md-4 col-form-label">Surat Peminjaman :</label>
                                <div class="col-md-8 text-start mt-2">
                                    @if($pinjams->surat_pinjam)
                                        @php
                                            $extension = pathinfo($pinjams->surat_pinjam, PATHINFO_EXTENSION);
                                            $isPDF = $extension === 'pdf';
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                            $fileName = pathinfo($pinjams->surat_pinjam, PATHINFO_FILENAME);
                                            $filePath = 'uploads/' . $pinjams->surat_pinjam;
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
                                <label for="status_pinjam" class="col-md-4 col-form-label">Status :</label>
                                <div class="col-auto mt-1">
                                    <span class="status-badge @if ($pinjams->status_pinjam === 'Menunggu Verifikasi') text-black bg-warning @elseif ($pinjams->status_pinjam === 'Diterima') text-white bg-success @else text-white bg-danger @endif">{{ $pinjams->status_pinjam }}</span>
                                </div>
                            </div>



                            <div class="form-group mb-2 row">
                                <label for="created_at" class="col-md-4 col-form-label">Created_at :</label>
                                <div class="col-md-8">
                                    <input type="created_at" readonly class="form-control-plaintext fw-bold" id="created_at" name="created_at" value="{{ $timestamps['createdTimestamp'] ?? '-' }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="updated_at" class="col-md-4 col-form-label">Updated_at :</label>
                                <div class="col-md-8">
                                    <input type="updated_at" readonly class="form-control-plaintext fw-bold" id="updated_at" name="updated_at" value="{{ $timestamps['updatedTimestamp'] ?? '-' }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="deleted_at" class="col-md-4 col-form-label">Deleted_at :</label>
                                <div class="col-md-8">
                                    <input type="deleted_at" readonly class="form-control-plaintext fw-bold" id="deleted_at" name="deleted_at" value="{{ $timestamps['deletedTimestamp'] ?? '-' }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="status_kembali" class="col-md-4 col-form-label">Verifikasi :</label>
                                <div class="col-md-8 text-start">
                                    @if ($pinjams->status_pinjam === 'Menunggu Verifikasi')
                                        <form action="{{ route('peminjaman.verifikasi', ['id' => $pinjams->id]) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-2 row">
                                                <div class="form-group mb-2 row">
                                                    <div class="col-md-12">
                                                        <button type="submit" name="status_pinjam" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                                        <button type="submit" name="status_pinjam" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <span class="badge bg-success"><i class="fa-solid fa-check"></i></span>
                                    @endif
                                </div>
                            </div>

                            {{-- @if ($pinjams->status_pinjam === 'Menunggu Verifikasi')
                                <div class="form-group mb-2 row">
                                    <label for="status_pinjam" class="col-md-4 col-form-label">Verifikasi :</label>
                                    <div class="col-md-8 text-start">
                                        <form action="{{ route('peminjaman.verifikasi', ['id' => $pinjams->id]) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-2 row">
                                                <div class="col-md-12">
                                                    <button type="submit" name="status_pinjam" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                                    <button type="submit" name="status_pinjam" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif --}}

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