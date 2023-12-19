@extends('sidebar.sekda')

@section('content')
<div class="container-fluid">
    <div class="row my-1">
        <h6><strong>{{ __('Lihat Aset') }}</strong></h6>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-1">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Detail Aset
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-secondary btn-sm" href="{{ url('seeAset/sekda') }}" role="button" style="width: fit-content"><i class="fa-solid fa-chevron-left pe-2"></i>Kembali</a>
                </div>
            </h6>
            <div class="card-body mx-2">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-9 offset-md-3">
                        <div class="form text-end">
                            <div class="form-group mb-2 row">
                                <label for="nama_aset" class="col-sm-2 col-form-label">Nama Aset :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="nama_aset" name="nama_aset" value="{{ $aset->nama_aset }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="kategori_id" class="col-sm-2 col-form-label">Kategori :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="kategori_id" name="kategori_id" value="{{ $aset->kategoris->jenis }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="dinas_id" class="col-sm-2 col-form-label">Dinas :</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext fw-bold" id="dinas_id" name="dinas_id" value="{{ $aset->dinas->nama_dinas }}">
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="status_aset" class="col-sm-2 col-form-label">Status :</label>
                                <div class="col-auto mt-1">
                                    <span class="status-badge @if ($aset->status_aset === 'Tersedia') text-white bg-primary @else text-white bg-secondary @endif" id="status_aset" name="status_aset" readonly>{{ $aset->status_aset }}</span>
                                </div>
                            </div>

                            <div class="form-group mb-2 row">
                                <label for="detail" class="col-sm-2 col-form-label">Detail :</label>
                                <div class="col-sm-9">
                                    <textarea readonly class="form-control-plaintext fw-bold" id="detail" name="detail" rows="3" style="text-align: justify;">{{ $aset->detail }}</textarea>
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

