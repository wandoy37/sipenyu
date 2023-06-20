<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPP | @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets2/img/logo-pemprov.png') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets2/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('assets2/css/fonts.min.css') }}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets2/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets2/css/atlantis.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets2/css/demo.css') }}">

    {{-- Leatflate Assets --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    {{-- /Leatflate Assets --}}

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 750px;
            width: 100%;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue2">

                <a href="index.html" class="logo">
                    <span class="text-light fw-bold">
                        <div class="text-center">
                            SIPP
                        </div>
                    </span>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            @include('layouts.partials.navbar')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">

            {{-- Section content --}}
            <div class="container">
                @yield('content')
            </div>
            {{-- /Section content --}}

            <footer class="footer">
                {{-- Section Footer --}}
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                        {{ date('Y') }}, made with <i class="fa fa-heart heart text-danger"></i> by
                        <span class="text-secondary">Muhammad Riswandi</span>
                    </div>
                </div>
                {{-- /Section Footer --}}
            </footer>
        </div>
    </div>

    @stack('scripts')

    <!--   Core JS Files   -->
    <script src="{{ asset('assets2/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets2/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets2/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets2/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets2/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets2/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Moment JS -->
    <script src="{{ asset('assets2/js/plugin/moment/moment.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets2/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets2/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets2/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets2/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets2/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Bootstrap Toggle -->
    <script src="{{ asset('assets2/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets2/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets2/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

    <!-- Google Maps Plugin -->
    <script src="{{ asset('assets2/js/plugin/gmaps/gmaps.js') }}"></script>

    <!-- Dropzone -->
    <script src="{{ asset('assets2/js/plugin/dropzone/dropzone.min.js') }}"></script>

    <!-- Fullcalendar -->
    <script src="{{ asset('assets2/js/plugin/fullcalendar/fullcalendar.min.js') }}"></script>

    <!-- DateTimePicker -->
    <script src="{{ asset('assets2/js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Bootstrap Tagsinput -->
    <script src="{{ asset('assets2/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <!-- Bootstrap Wizard -->
    <script src="{{ asset('assets2/js/plugin/bootstrap-wizard/bootstrapwizard.js') }}"></script>

    <!-- jQuery Validation -->
    <script src="{{ asset('assets2/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('assets2/js/plugin/summernote/summernote-bs4.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets2/js/plugin/select2/select2.full.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets2/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('assets2/js/plugin/owl-carousel/owl.carousel.min.js') }}"></script>

    <!-- Magnific Popup -->
    <script src="{{ asset('assets2/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('assets2/js/atlantis.min.js') }}"></script>
</body>

</html>
