<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('nvAdmin.name', 'APS') }}</title>

        <!-- Scripts -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/d0c04e8934.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('js/app.js') }}" />
    </head>
    <body>
        <div id="nvAdmin">
            <div class="wrapper">
                <aside id="sidebar" class="js-sidebar">
                    <!-- Content for Sidebar -->
                    <div class="vh-100 overflow-auto pb-2">
                        <div class="sidebar-logo">
                            <img src="{{ asset('img/logojpr.png') }}" class="logo-responsive" alt="logo">
                            <a href="#">Jepara APS</a>
                        </div>
                        <ul class="sidebar-nav">
                            <li class="sidebar-header">
                                {{ __('Super Admin') }}
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-list pe-2"></i>{{ __('Dashboard') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#kelolaAset" aria-expanded="false">
                                    <i class="fa-solid fa-file-pen pe-2"></i>{{ __('Kelola Aset') }}
                                </a>
                                <ul id="kelolaAset" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="{{ url('kategori/index') }}" class="sidebar-link">{{ __('Kategori') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ url('aset/index') }}" class="sidebar-link">{{ __('Aset') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="{{ route('user') }}" class="sidebar-link">
                                    <i class="fa-solid fa-user-pen pe-2"></i>{{ __('Kelola Pengguna') }}
                                </a>
                                {{-- <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#kelolaUser" aria-expanded="false">
                                    <i class="fa-solid fa-user-pen pe-2"></i>{{ __('Kelola Pengguna') }}
                                </a>
                                <ul id="kelolaUser" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Super Admin') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Sekretaris Daerah') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('OPD') }}</a>
                                    </li>
                                </ul> --}}
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-file-circle-plus pe-2"></i>{{ __('Peminjaman') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fa-solid fa-file-export pe-2"></i>{{ __('Pengembalian') }}
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#kelolaLaporan" aria-expanded="false">
                                    <i class="fa-solid fa-file-signature pe-2"></i>{{ __('Kelola Laporan') }}
                                </a>
                                <ul id="kelolaLaporan" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Peminjaman') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Pengembalian') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                    <i class="fas fa-history pe-2"></i></i>{{ __('Riwayat') }}
                                </a>
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

                        <div class="navbar-collapse navbar">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link text-white my-2 mx-2 position-relative" href="#" role="button" aria-expanded="false">
                                        <i class="fa-solid fa-bell fa-lg text-white"></i>
                                        <span class="badge rounded-pill badge-notification bg-danger position-absolute top-0 d-block" style="left: 17px;">{{ __('#') }}</span>
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
