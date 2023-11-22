@extends('sidebar.superadmin')

@section('content')
<div class="container-fluid">
    <div class="mb-3 mt-3">
        <h5>{{ __('Dashboard Super Admin') }}</h5>
    </div>
    <div class="row">
        <div class="card flex-fill border-0">
            <div class="card-header">
                <div class="card-title p-3 m-1">
                    <h4>{{ __('Riwayat Penjualan') }}</h4>
                </div>
            </div>
            <div class="card-body p-0 d-flex flex-fill">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    

</div>
@endsection

