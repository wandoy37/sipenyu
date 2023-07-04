<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPP @yield('title')</title>
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">
    <!-- Style (Custome UPTD BPPSDMP) -->
    <link rel="stylesheet" href="{{ asset('assets') }}/style.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/img/logo.png">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,300&display=swap"
        rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/5983388006.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/leaflet-plugin/leaflet.ajax.min.js') }}"></script>
    <script src="https://www.unpkg.com/spin@0.0.1/dist/spin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.Spin/1.1.2/leaflet.spin.min.js"></script>

    <style>
        #map {
            height: 500px;
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    @include('home.layouts.navbar')
    {{-- /Navbar --}}

    {{-- Main --}}
    @yield('content')
    {{-- /Main --}}

    <!-- Footer -->
    <section id="footer">
        <div class="container px-4">
            <div class="row gx-5">
                <div class="col-lg-5">
                    <a class="font-title-footer text-decoration-none text-white" href="#">
                        <img src="{{ asset('assets') }}/img/logo.png" alt="Logo" width="40"
                            class="d-inline-block align-text-top img-navbar">
                        UPTD BPPSDMP
                    </a>
                    <div class="text-brand-footer">
                        <p>Balai Penyuluhan dan Pengembangan Sumber Daya Manusia Pertanian</p>
                        <p>Jl. Thoyib Hadiwijaya No.36, Sempaja Selatan, Samarinda - Kalimantan Timur</p>
                    </div>
                </div>
                <div class="col-lg-3 ms-auto">
                    <span class="font-title-2">Kontak Kami</span>
                    <ul class="list-no-bullet" style="margin-top: 1rem;">
                        <li>(+62) 821 4872 2747</li>
                        <li>bppsdmpsempaja@gmail.com</li>
                        <li>@uptd_bppsdmpsempaja</li>
                    </ul>
                </div>
                <div class="col-lg-3 ms-auto">
                    <span class="font-title-2">Mitra Kerja</span>
                    <ul class="list-no-bullet" style="margin-top: 1rem;">
                        <li>KTNA</li>
                        <li>PETANI ANDALAN / MILENIAL</li>
                        <li>PERHIPTANI</li>
                        <li>P4S</li>
                        <li>IKAMAJA</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
        integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>

</html>
