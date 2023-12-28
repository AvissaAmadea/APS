<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('nvSekda.name', 'APS') }}</title>

        <!-- Scripts -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/d0c04e8934.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('js/app.js') }}" />
    </head>
    <body>
        <div id="nvSekda">
            <div class="wrapper">
                <aside id="sidebar" class="js-sidebar">
                    <!-- Content for Sidebar -->
                    <div class="vh-100 overflow-auto">
                        <div class="sidebar-logo">
                            <img src="{{ asset('img/logojpr.png') }}" class="logo-responsive" alt="logo">
                            <a href="#">Jepara APS</a>
                        </div>
                        <ul class="sidebar-nav">
                            <li class="sidebar-header">
                                {{ __('Sekretaris Daerah') }}
                            </li>

                            <li class="sidebar-item">
                                @if(Auth::check())
                                    @if(Auth::user()->role_id == 1)
                                        <a href="{{ route('dashboard.superadmin') }}" class="sidebar-link">
                                            <i class="fa-solid fa-list pe-2"></i>{{ __('Dashboard') }}
                                        </a>
                                    @elseif(Auth::user()->role_id == 2)
                                        <a href="{{ route('dashboard.sekda') }}" class="sidebar-link">
                                            <i class="fa-solid fa-list pe-2"></i>{{ __('Dashboard') }}
                                        </a>
                                    @elseif(Auth::user()->role_id == 3)
                                        <a href="{{ route('dashboard.opd') }}" class="sidebar-link">
                                            <i class="fa-solid fa-list pe-2"></i>{{ __('Dashboard') }}
                                        </a>
                                    @endif
                                @endif
                            </li>

                            <li class="sidebar-item">
                                <a href="{{ route('seeAset.sekda') }}" class="sidebar-link">
                                    <i class="fa-solid fa-clipboard-list pe-2"></i>{{ __('   Lihat Aset') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{ route('peminjaman.sekda.create') }}" class="sidebar-link">
                                    <i class="fa-solid fa-file-circle-plus pe-2"></i>{{ __('Peminjaman') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{ route('pengembalian.sekda.create') }}" class="sidebar-link">
                                    <i class="fa-solid fa-file-export pe-2"></i>{{ __('Pengembalian') }}
                                </a>
                            </li>

                            {{-- <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-file-invoice-dollar pe-2"></i>{{ __('  Penetapan Sanksi') }}
                                </a>
                            </li> --}}

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-money-bill-transfer pe-2"></i>{{ __('Pembayaran') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#verifikasi" aria-expanded="false">
                                    <i class="fa-solid fa-file-signature pe-2"></i>{{ __('Verifikasi') }}
                                </a>
                                <ul id="verifikasi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="{{ route('peminjaman.sekda.index') }}" class="sidebar-link">{{ __('Peminjaman') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('pengembalian.sekda.index') }}" class="sidebar-link">{{ __('Pengembalian') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#lihatLaporan" aria-expanded="false">
                                   <i class="fa-solid fa-file-contract pe-2"></i>{{ __('   Laporan-laporan') }}
                                </a>
                                <ul id="lihatLaporan" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Peminjaman') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Pengembalian') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                 {{-- <a href="#" class="sidebar-link">
                                    <i class="fas fa-history pe-2"></i></i>{{ __('Riwayat') }}
                                </a> --}}
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#riwayat" aria-expanded="false">
                                    <i class="fa-solid fa-file-lines pe-2"></i>{{ __('  Riwayat') }}
                                </a>
                                <ul id="riwayat" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        @if(Auth::check() && Auth::user()->role_id == 2)
                                            <a href="{{ route('peminjaman.sekda.riwayat') }}" class="sidebar-link">{{ __('Peminjaman') }}</a>
                                        @endif
                                    </li>
                                    <li class="sidebar-item">
                                        @if(Auth::check() && Auth::user()->role_id == 2)
                                            <a href="{{ route('pengembalian.sekda.riwayat') }}" class="sidebar-link">{{ __('Pengembalian') }}</a>
                                        @endif
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-gear pe-2"></i></i>{{ __('Pengaturan') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket pe-2"></i>{{ __('Keluar') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                </aside>

                <div class="main">
                    <nav class="navbar navbar-expand px-3 border-bottom">
                        <button class="navbar-btn" id="sidebar-toggle" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="navbar-collapse navbar pt-2 pb-0">
                            <ul class="navbar-nav p-0">
                                <li class="nav-item">
                                    <a class="nav-link text-white my-2 mx-2 position-relative" href="#" role="button" aria-expanded="false">
                                        <i class="fa-solid fa-bell fa-lg text-white"></i>
                                        <span class="badge rounded-pill badge-notification bg-danger position-absolute top-0 d-block" style="left: 20px;">{{ __('#') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link fw-bold text-white" role="button" aria-expanded="false">
                                        <i class="pe-1"><img src="{{ asset('img/person.png') }}" class="avatar img-fluid rounded-circle" alt=""></i>
                                        {{ Auth::user()->nama }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <main class="content px-3 py-2">
                        @yield('content')
                    </main>

                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row text-muted">
                                <div class="col-6 text-start">
                                    <p class="mb-2">
                                        <a href="#" class="text-muted">
                                            <strong>© 2023 Jepara APS</strong>
                                        </a>
                                    </p>
                                </div>
                                <!-- <div class="col-6 text-end">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="#" class="text-muted">{{ __('Kontak') }}</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="text-muted">{{ __('Tentang Kami') }}</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </footer>


                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
