@extends('sidebar.superadmin')

@section('content')
<!-- Tambahkan loading indicator -->
{{-- <div class="loading-indicator">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div> --}}

<div class="container-fluid">
    <div class="row mt-2 mb-0 px-2" aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item active fw-bold" aria-current="page">Dashboard</li>
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
    </div>

    <div class="row row-cols-1 row-cols-md-5 g-2 mb-2">
        <div class="col">
          <div class="card text-white mb-2" style="background-color: #000080">
            <div class="card-body">
              <h6 class="card-title">Total Pengguna</h6>
              <h4 class="card-text fw-bold d-flex align-items-center justify-content-between">
                {{ $users }}
                <i class="fa-solid fa-users"></i>
              </h4>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('user.index') }}" class="small text-white stretched-link">Show Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>

          <div class="col">
            <div class="card text-white mb-2" style="background-color: #033E3E">
              <div class="card-body">
                <h6 class="card-title">Total Kategori</h6>
                <h4 class="card-text fw-bold d-flex align-items-center justify-content-between">
                  {{ $kategoris }}
                  <i class="fa-solid fa-warehouse"></i>
                </h4>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                  <a href="{{ route('kategori.index') }}" class="small text-white stretched-link">Show Details</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card mb-2 text-white" style="background-color: #622F22">
              <div class="card-body">
                <h6 class="card-title">Total Aset</h6>
                <h4 class="card-text fw-bold d-flex align-items-center justify-content-between">
                  {{ $allAsets }}
                  <i class="fa-solid fa-warehouse"></i>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                  <a href="{{ route('aset.index') }}" class="small text-white stretched-link">Show Details</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
              </div>
            </div>
          </div>

            <div class="col">
              <div class="card mb-2 text-white" style="background-color: #4B0150">
                <div class="card-body">
                  <h6 class="card-title">Total Peminjaman</h6>
                  <h4 class="card-text fw-bold d-flex align-items-center justify-content-between">
                    {{ $peminjamans }}
                    <i class="fa-solid fa-file-import"></i>
                  </h4>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('peminjaman.superadmin.index') }}" class="small text-white stretched-link">Show Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
              </div>
            </div>

          <div class="col">
            <div class="card mb-2 text-white" style="background-color: #550A35">
              <div class="card-body">
                <h6 class="card-title">Total Pengembalian</h6>
                <h4 class="card-text fw-bold d-flex align-items-center justify-content-between">
                  {{ $pengembalians }}
                  <i class="fa-solid fa-file-export"></i>
                </h4>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                  <a href="{{ route('pengembalian.superadmin.index') }}" class="small text-white stretched-link">Show Details</a>
                  <div class="small text-white"><i class="fas fa-angle-right"></i></div>
              </div>
            </div>
          </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <div class="card">
                <canvas id="grafikPeminjaman" width="200" height="90"></canvas>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <canvas id="grafikPengembalian" width="200" height="90"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <div class="card">
                <canvas id="grafikTrenPeminjaman" width="300" height="150"></canvas>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <canvas id="grafikTrenPengembalian" width="300" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-2 px-2">
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Daftar Pengajuan Peminjaman
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <form class="form-search d-flex" method="GET" action="#">
                        <div class="input-group">
                            <input type="search" id="inputSearch" class="form-control" placeholder="Cari" style="max-width: 15rem; height: 33px"/>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </h6>
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-2">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Kode</th>
                              <th scope="col">Nama Aset</th>
                              <th scope="col">Asal Aset</th>
                              <th scope="col">Waktu Pinjam</th>
                              <th scope="col">Waktu Kembali</th>
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($pinjams->count() > 0)
                            @foreach ($pinjams as $key => $item)
                                <tr class="text-center">
                                    <th>{{ ( $pinjams->firstItem() + $key ) }}</th>
                                    <td>{{ ( $item->kode_pinjam ) }}</td>

                                    {{-- Tampilkan nama aset dan nama dinas aset --}}
                                    @if(isset($nama_aset[$key]) && isset($nama_dinas_aset[$key]))
                                        <td>{{ $nama_aset[$key] }}</td>
                                        <td>{{ $nama_dinas_aset[$key] }}</td>
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif

                                    <td style="width: 8rem">{{ $tgl_pinjam_date[$key] ?? '' }} {{ $tgl_pinjam_time[$key] ?? '' }}</td>
                                    <td style="width: 8rem">{{ $tgl_kembali_date[$key] ?? '' }} {{ $tgl_kembali_time[$key] ?? '' }}</td>
                                    {{-- <td>{{ ( $item->status_pinjam ) }}</td> --}}
                                    <td style="width: 5rem">
                                        <span class="status-badge @if ($item->status_pinjam === 'Menunggu Verifikasi') text-black bg-warning @elseif ($item->status_pinjam === 'Diterima') text-white bg-success @else text-white bg-danger @endif">{{ $item->status_pinjam }}</span>
                                    </td>
                                    <td class="text-center" style="width: 3rem">
                                        <a class="btn btn-info btn-sm" href="{{ route('peminjaman.superadmin.show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        {{-- <a class="btn btn-warning btn-sm" href="#" role="button"><i class="fa-solid fa-file-export"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
            <div class="card-footer mb-0 pb-0">
                {{-- {{ $pinjams->appends(request()->query())->links('pagination::bootstrap-5') }} --}}
                {{ $pinjams->appends(['pinjams' => $pinjams->currentPage(), 'kembali' => $kembali->currentPage(), 'asets' => $asets->currentPage()])->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="row mb-2 px-2">
        <div class="card flex-fill border-0 p-2">
            <h6 class="card-header d-flex justify-content-between align-items-center">
                Daftar Pengajuan Pengembalian
            </h6>
            <div class="card-body p-0 d-flex flex-fill mx-2 mt-3">
                <!-- <div class="table-responsive"> -->
                  <table class="table table-bordered border-dark align-middle">
                      <thead >
                          <tr class="text-center table-dark">
                              <th scope="col">No.</th>
                              <th scope="col">Nama Aset</th>
                              <th scope="col">Asal Aset</th>
                              <th scope="col">Waktu Pinjam</th>
                              <th scope="col">Waktu Kembali</th>
                              <th scope="col">Status</th>
                              <th scope="col">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @if ($kembali->count() > 0)
                            @foreach ($kembali as $key => $item)
                                <tr class="text-center">
                                    <th style="width: 3rem">{{ ( $kembali->firstItem() + $key ) }}</th>

                                    {{-- Tampilkan nama aset dan nama dinas aset --}}
                                    @if(isset($nama_aset[$key]) && isset($nama_dinas_aset[$key]))
                                        <td>{{ $nama_aset[$key] }}</td>
                                        <td>{{ $nama_dinas_aset[$key] }}</td>
                                    @else
                                        <td>-</td>
                                        <td>-</td>
                                    @endif

                                    <td style="width: 8rem">{{ $tgl_pinjam_date[$key] ?? '' }} {{ $tgl_pinjam_time[$key] ?? '' }}</td>
                                    <td style="width: 8rem">{{ $tgl_kembali_date[$key] ?? '' }} {{ $tgl_kembali_time[$key] ?? '' }}</td>

                                    <td style="width: 5rem">
                                        <span class="status-badge @if ($item->status_kembali === 'Menunggu Verifikasi') text-black bg-warning @elseif ($item->status_kembali === 'Diterima') text-white bg-success @elseif ($item->status_kembali === 'Menunggu Pembayaran') text-white bg-primary @else text-white bg-danger @endif">{{ $item->status_kembali }}</span>
                                    </td>
                                    <td class="text-center" style="width: 3rem">
                                        <a class="btn btn-info btn-sm" href="{{ route('pengembalian.superadmin.show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        {{-- <a class="btn btn-warning btn-sm" href="{{ route('pengembalian.superadmin.edit', $item->id) }}" role="button"><i class="fa-solid fa-pen"></i></a> --}}
                                        {{-- <a class="btn btn-success btn-sm" href="#" role="button"><i class="fa-solid fa-file-signature"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Data Kosong</td>
                            </tr>
                        @endif
                      </tbody>
                  </table>
                <!-- </div> -->
            </div>
            <div class="card-footer mb-0 pb-0">
                {{-- {{ $kembali->appends(request()->query())->links('pagination::bootstrap-5') }} --}}
                {{ $kembali->appends(['pinjams' => $pinjams->currentPage(), 'kembali' => $kembali->currentPage(), 'asets' => $asets->currentPage()])->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="row mb-2 px-2">
            <div class="card flex-fill border-0 p-2">
                <h6 class="card-header d-flex justify-content-between align-items-center">
                    Data Aset
                </h6>
                <div class="card-body p-0 d-flex flex-fill mx-2 mt-3">
                    <!-- <div class="table-responsive"> -->
                      <table class="table table-bordered border-dark align-middle">
                          <thead >
                              <tr class="text-center table-dark">
                                  <th scope="col">No.</th>
                                  <th scope="col">Nama Aset</th>
                                  <th scope="col">Kategori</th>
                                  <th scope="col">Dinas</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                            @if ($asets->count() > 0)
                                @foreach ($asets as $key => $item)
                                    <tr class="text-center">
                                        <th style="width: 3rem">{{ ( $asets->firstItem() + $key ) }}</th>
                                        <td>{{ ( $item->nama_aset ) }}</td>
                                        <td>{{ ( $item->kategoris->jenis ) }}</td>
                                        <td>{{ ( $item->dinas->nama_dinas ) }}</td>
                                        {{-- <td>{{ ( $item->status_aset ) }}</td> --}}
                                        {{-- <td class="@if ($item->status_aset === 'Tersedia') text-white bg-primary @else text-white bg-secondary @endif">{{ $item->status_aset }}</td> --}}
                                        <td>
                                            <span class="status-badge @if ($item->status_aset === 'Tersedia') text-white bg-primary @else text-white bg-secondary @endif">{{ $item->status_aset }}</span>
                                        </td>

                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('aset.show', $item->id) }}" role="button"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                            @endif
                          </tbody>
                      </table>
                </div>
                <div class="card-footer mb-0 pb-0">
                    {{-- {{ $asets->appends(request()->query())->links('pagination::bootstrap-5') }} --}}
                    {{ $asets->appends(['pinjams' => $pinjams->currentPage(), 'kembali' => $kembali->currentPage(), 'asets' => $asets->currentPage()])->links('pagination::bootstrap-5') }}                </div>
            </div>
    </div>

</div>

<script>
// Grafik Peminjaman
const tahunPeminjaman = {!! $tahunPeminjaman !!};
const labelsPeminjaman = {!! $labelsPeminjaman !!};
const jumlahPeminjamanPerBulan = {!! $jumlahPeminjamanPerBulan !!};

function renderPeminjamanChart() {
    const ctx = document.getElementById('grafikPeminjaman').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsPeminjaman,
            datasets: [{
                label: 'Jumlah Peminjaman per Bulan',
                data: jumlahPeminjamanPerBulan,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                tahun: tahunPeminjaman // Pastikan variabel tahun terisi dengan benar
            }]
        },
        options: {
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        display: 'auto',
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const tahun = tahunPeminjaman[context.dataIndex];
                            const label = labelsPeminjaman[context.dataIndex];
                            return `Bulan: ${label}, Jumlah: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
}

// Rencanakan struktur data untuk grafik tren
const dataTrenPeminjaman = {
    labels: labelsPeminjaman,
    datasets: [{
        label: 'Tren Peminjaman',
        data: jumlahPeminjamanPerBulan,
        fill: false,
        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis tren
        tension: 0.1 // Tension untuk kurva tren
    }]
};

// Buat grafik tren peminjaman dari waktu ke waktu
const ctxTrenPeminjaman = document.getElementById('grafikTrenPeminjaman').getContext('2d');
new Chart(ctxTrenPeminjaman, {
    type: 'line',
    data: dataTrenPeminjaman,
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: '2024'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Jumlah Peminjaman'
                }
            }
        }
    }
});

// Grafik Pengembalian
const tahunPengembalian = {!! $tahunPengembalian !!};
const labelsPengembalian = {!! $labelsPengembalian !!};
const jumlahPengembalianPerBulan = {!! $jumlahPengembalianPerBulan !!};

function renderPengembalianChart() {
    const ctx = document.getElementById('grafikPengembalian').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsPengembalian,
            datasets: [{
                label: 'Jumlah Pengembalian per Bulan',
                data: jumlahPengembalianPerBulan,
                backgroundColor: 'rgba(50, 205, 50, 0.2)',
                borderColor: 'rgba(50, 205, 50, 1)',
                borderWidth: 1,
                tahun: tahunPengembalian // Pastikan variabel tahun terisi dengan benar
            }]
        },
        options: {
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        display: 'auto'
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const tahun = tahunPengembalian[context.dataIndex];
                            const label = labelsPengembalian[context.dataIndex];
                            return `Bulan: ${label}, Jumlah: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
}

// Rencanakan struktur data untuk grafik tren
const dataTrenPengembalian = {
    labels: labelsPengembalian,
    datasets: [{
        label: 'Tren Pengembalian',
        data: jumlahPengembalianPerBulan,
        fill: false,
        borderColor: 'rgba(50, 205, 50, 1)', // Warna garis tren
        tension: 0.1 // Tension untuk kurva tren
    }]
};

// Buat grafik tren pengembalian dari waktu ke waktu
const ctxTrenPengembalian = document.getElementById('grafikTrenPengembalian').getContext('2d');
new Chart(ctxTrenPengembalian, {
    type: 'line',
    data: dataTrenPengembalian,
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: '2024'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Jumlah Pengembalian'
                }
            }
        }
    }
});


window.onload = function() {
    renderPeminjamanChart();
    renderPengembalianChart();
};

</script>

@endsection

