@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Pengajuan Peminjaman') }}</strong></h6>
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
            <h6 class="card-header">Form Pengajuan Peminjaman</h6>
            <div class="card-body mx-2">
                <form class="form text-end" method="POST" action="{{ route('peminjaman/sekda') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-2 row">
                        <label for="kode_pinjam" class="col-sm-2 col-form-label">Kode Peminjaman</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="kode_pinjam" name="kode_pinjam" value="{{ Str::random(4) }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="nama" name="nama" value="{{ Auth::user()->nama }}" autofocus>
                        </div>
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="aset_id" class="col-sm-2 col-form-label">Aset</label>
                        <div class="col-sm-10">
                            <select class="form-select @error('aset_id') is-invalid @enderror" type="select" id="aset_id" name="aset_id" required autofocus>
                                <option value="" selected disabled>-- Pilih Aset --</option>
                                @foreach ($asets as $asetData)
                                    <option value="{{ $asetData->id }}" {{ old('aset_id') == $asetData->id ? 'selected' : null }}>{{ $asetData->nama_aset }}</option>
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
                        <label for="tgl_pinjam" class="col-sm-2 col-form-label">Waktu Pinjam</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control @error('tgl_pinjam') is-invalid @enderror" id="tgl_pinjam" name="tgl_pinjam" min="{{ date('Y-m-d\TH:i', strtotime('+3 days')) }}" value="{{ old('tgl_pinjam') }}" required autofocus>
                        </div>
                        @error('tgl_pinjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="tgl_kembali" class="col-sm-2 col-form-label">Waktu Kembali</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" name="tgl_kembali" min="{{ date('Y-m-d\TH:i', strtotime('+3 days')) }}" value="{{ old('tgl_kembali') }}" required autofocus>
                        </div>
                        @error('tgl_kembali')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="tujuan" class="col-sm-2 col-form-label">Keperluan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" name="tujuan" value="{{ old('tujuan') }}" required autofocus rows="5"></textarea>
                        </div>
                        @error('tujuan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2 row">
                        <label for="surat_pinjam" class="col-sm-2 col-form-label">Surat Peminjaman</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('surat_pinjam') is-invalid @enderror" id="surat_pinjam" name="surat_pinjam" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" value="{{ old('surat_pinjam') }}" required autofocus>
                        </div>
                        @error('surat_pinjam')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success btn-sm float-right mb-0 mt-2" name="submit">Tambah</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

