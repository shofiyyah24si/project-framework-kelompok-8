<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>@yield('title', 'Laravel App')</title>

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('landing/assets/favicon.ico') }}" />

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
              rel="stylesheet" type="text/css" />

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic"
              rel="stylesheet" type="text/css" />

        <!-- Core theme CSS (includes Bootstrap) -->
        <link href="{{ asset('landing/css/styles.css') }}" rel="stylesheet" />

        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @stack('styles')
    </head>
    <body>
        {{-- NAVBAR GLOBAL -- HANYA TAMPIL JIKA BUKAN LANDING PAGE --}}
        @if(!request()->is('/'))
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route('landing') }}">
                    <img src="{{ asset('images/logoD.png') }}" 
                         alt="Tanggap Darurat" 
                         height="40"
                         style="max-height: 40px;">
                </a>

                {{-- MENU UTAMA (tanpa kotak, hanya link) --}}
                <ul class="nav align-items-center">
                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'fw-bold text-dark' : 'text-secondary' }}">
                            Dashboard
                        </a>
                    </li>

                    {{-- Data Warga --}}
                    <li class="nav-item">
                        <a href="{{ route('warga.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('warga.*') ? 'fw-bold text-danger' : 'text-secondary' }}">
                            Data Warga
                        </a>
                    </li>

                    {{-- Kejadian Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('kejadian.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('kejadian.*') ? 'fw-bold text-warning' : 'text-secondary' }}">
                            Kejadian Bencana
                        </a>
                    </li>

                    {{-- Posko Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('posko.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('posko.*') ? 'fw-bold text-success' : 'text-secondary' }}">
                            Posko Bencana
                        </a>
                    </li>

                    {{-- Donasi Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('donasi.index') }}"
                           class="nav-link px-3 {{ request()->routeIs('donasi.*') ? 'fw-bold text-info' : 'text-secondary' }}">
                            Donasi Bencana
                        </a>
                    </li>

                    {{-- Logistik Bencana --}}
                    <li class="nav-item">
                        <a href="{{ route('logistik.index') }}"
                           class="nav-link pe-2 {{ request()->routeIs('logistik.*') ? 'fw-bold text-purple' : 'text-secondary' }}">
                            Logistik Bencana
                        </a>
                    </li>

                    {{-- Distribusi Logistik --}}
                    <li class="nav-item">
                        <a href="{{ route('distribusi.index') }}"
                           class="nav-link pe-2 {{ request()->routeIs('distribusi.index*') ? 'fw-bold text-orange' : 'text-secondary' }}">
                            Distribusi Logistik
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        @endif

        {{-- KONTEN HALAMAN --}}
        @yield('content')

        {{-- FOOTER GLOBAL -- TETAP ADA DI SEMUA HALAMAN --}}
        <footer class="footer bg-light mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><a href="#!">Tentang</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Kontak</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Syarat Penggunaan</a></li>
                            <li class="list-inline-item">⋅</li>
                            <li class="list-inline-item"><a href="#!">Kebijakan Privasi</a></li>
                        </ul>
                        <p class="text-muted small mb-4 mb-lg-0">
                            &copy; Sistem Tanggap Darurat {{ date('Y') }}. Hak Cipta Dilindungi.
                        </p>
                    </div>
                    <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-facebook fs-3"></i></a>
                            </li>
                            <li class="list-inline-item me-4">
                                <a href="#!"><i class="bi-twitter fs-3"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#!"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Core theme JS-->
        <script src="{{ asset('landing/js/scripts.js') }}"></script>

        <style>
        /* Custom color for logistik menu */
        .text-purple {
            color: #6f42c1 !important;
        }
        
        /* Custom color for distribusi logistik menu */
        .text-orange {
            color: #fd7e14 !important;
        }
        
        /* Responsive menu for mobile */
        @media (max-width: 992px) {
            .nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-item {
                margin-bottom: 5px;
            }
            
            .nav-link {
                padding: 0.5rem 1rem !important;
            }
        }
        </style>

        @stack('scripts')
    </body>
</html>