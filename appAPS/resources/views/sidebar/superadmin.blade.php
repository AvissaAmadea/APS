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
        
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    </head>
    <body>
        <div id="nvAdmin">
            <div class="wrapper">
                <aside id="sidebar">
                    <!-- Content for Sidebar -->
                    <div class="h-100">
                        <div class="sidebar-logo">
                            <img src="{{ asset('img/logojpr.png') }}" class="logo-responsive" alt="logo">
                            <a href="#">{{ __('Jepara APS') }}</a>
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
                                        <a href="#" class="sidebar-link">{{ __('Kategori') }}</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">{{ __('Aset') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#kelolaUser" aria-expanded="false">
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
                                </ul>
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

                        </ul>
                    </div>
                </aside>

                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>