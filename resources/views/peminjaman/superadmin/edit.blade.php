@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row mt-2" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.superadmin') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('peminjaman.superadmin.index') }}">Daftar Pengajuan Peminjaman</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">Edit Pengajuan Peminjaman</li>
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
                    <a class="btn btn-secondary btn-sm" href="{{ route('peminjaman.superadmin.index') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-2 row">
                        <label for="kode_pinjam" class="col-sm-3 col-form-label">Kode Peminjaman</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control" id="kode_pinjam" name="kode_pinjam" value="{{ $peminjaman->kode_pinjam }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="user_name" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $peminjaman->users->nama }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="aset_id" class="col-sm-3 col-form-label">Aset</label>
                        <div class="col-sm-9">
                            <select class="form-select @error('aset_id') is-invalid @enderror" type="select" id="aset_id" name="aset_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Aset --</option>
                                @foreach ($asets as $asetData)
                                    <option value="{{ $asetData->id }}" {{ $peminjaman->aset_id == $asetData->id ? 'selected' : null }}>{{ $asetData->nama_aset }}</option>
                                @endforeach
                            </select>
                            @error('aset_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="tgl_pinjam" class="col-sm-3 col-form-label">Waktu Pinjam</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class="form-control @error('tgl_pinjam') is-invalid @enderror" id="tgl_pinjam" name="tgl_pinjam"
                            min="{{ \Carbon\Carbon::now()->addDays(3)->setTime(0, 0, 0)->format('Y-m-d\TH:i') }}" value="{{ $peminjaman->tgl_pinjam }}" required autofocus>
                            {{-- <input type="datetime-local" class="form-control @error('tgl_pinjam') is-invalid @enderror" id="tgl_pinjam" name="tgl_pinjam" min="{{ date('Y-m-d\TH:i', strtotime('+3 days')) }}" value="{{ old('tgl_pinjam') }}" required autofocus> --}}
                        </div>
                        @error('tgl_pinjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="tgl_kembali" class="col-sm-3 col-form-label">Waktu Kembali</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" name="tgl_kembali"
                            min="{{ \Carbon\Carbon::now()->addDays(3)->setTime(0, 0, 0)->format('Y-m-d\TH:i') }}" value="{{ $peminjaman->tgl_kembali }}" required autofocus>
                            {{-- <input type="datetime-local" class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" name="tgl_kembali" min="{{ date('Y-m-d\TH:i', strtotime('+3 days')) }}" value="{{ old('tgl_kembali') }}" required autofocus> --}}
                        </div>
                        @error('tgl_kembali')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="tujuan" class="col-sm-3 col-form-label">Keperluan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" required autofocus rows="5">{{ $peminjaman->tujuan }}</textarea>
                        </div>
                        @error('tujuan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="surat_pinjam" class="col-sm-3 col-form-label">Surat Peminjaman</label>
                        <div class="col-sm-9 text-start mt-2">
                            @if($peminjaman->surat_pinjam)
                                @php
                                    $extension = pathinfo($peminjaman->surat_pinjam, PATHINFO_EXTENSION);
                                    $isPDF = $extension === 'pdf';
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                    $fileName = pathinfo($peminjaman->surat_pinjam, PATHINFO_FILENAME);
                                    $filePath = 'uploads/' . $peminjaman->surat_pinjam;
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
                        <label for="surat_pinjam" class="col-sm-3 col-form-label">Ubah Surat Peminjaman</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('surat_pinjam') is-invalid @enderror" id="surat_pinjam" name="surat_pinjam" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" autofocus>
                        </div>
                        @error('surat_pinjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="status_pinjam" class="col-sm-3 col-form-label">Status Peminjaman</label>
                        <div class="col-sm-9 text-start mt-1">
                            <!-- Display current file name -->
                            {{-- <h6>{{ $peminjaman->status_pinjam }}</h6> --}}
                            <span class="status-badge @if ($peminjaman->status_pinjam === 'Menunggu Verifikasi') text-black bg-warning @elseif ($peminjaman->status_pinjam === 'Diterima') text-white bg-success @else text-white bg-danger @endif">{{ $peminjaman->status_pinjam }}</span>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="status_pinjam" class="col-sm-3 col-form-label">Ubah Status Peminjaman</label>
                        <div class="col-sm-9 text-start">
                            <form action="{{ route('peminjaman.verifikasi', ['id' => $peminjaman->id]) }}" method="POST">
                                @csrf
                                <div class="form-group mb-2 row">
                                    <div class="col-md-12">
                                        @if($peminjaman->status_pinjam === 'Diterima')
                                            <button type="submit" name="status_pinjam" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button>
                                            <button type="submit" name="status_pinjam" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                        @elseif($peminjaman->status_pinjam === 'Menunggu Verifikasi')
                                            <button type="submit" name="status_pinjam" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                            <button type="submit" name="status_pinjam" value="Ditolak" class="btn btn-sm btn-danger">Ditolak</button>
                                        @elseif($peminjaman->status_pinjam === 'Ditolak')
                                            <button type="submit" name="status_pinjam" value="Menunggu Verifikasi" class="btn btn-sm btn-warning">Menunggu Verifikasi</button>
                                            <button type="submit" name="status_pinjam" value="Diterima" class="btn btn-sm btn-success">Diterima</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm float-end mb-0 mt-2" name="submit">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

