@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="row my-2">
        <h5>{{ __('Kelola Kategori') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0 p-2">
            <div class="card-title my-2 mx-2">
                <div class="row">
                    <div class="col mt-1">
                        <h4>{{ __('Tambah Kategori') }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body mx-2 mt-2">
                <form class="form" method="GET" action="#">
                    <div class="form-group mb-3 row">
                        <label for="inputJenis" class="col-sm-2 col-form-label">{{ __('Jenis Kategori') }}</label>
                        <div class="col-sm-10">
                            <input type="teks" class="form-control" id="inputJenis">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-sm float-right mt-2" name="submit">Tambah</button>
                    </div>
                        
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

