@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>
                            <i class="fas fa-map"></i>
                            PETA
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('geojson/kaltim.js') }}"></script>
        <script>
            const map = L.map('map');

            map.createPane('labels');

            // This pane is above markers but below popups
            map.getPane('labels').style.zIndex = 650;

            // Layers in this pane are non-interactive and do not obscure mouse/touch events
            map.getPane('labels').style.pointerEvents = 'none';

            const cartodbAttribution =
                '&copy; <a href="https://www.openstreetmap.org/copyright">Dinas Pangan, Tanaman Pangan dan Hortikultura</a>, &copy; <a href="https://carto.com/attribution">BPPSDMP</a>';

            const positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
                attribution: cartodbAttribution
            }).addTo(map);

            const positronLabels = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
                attribution: cartodbAttribution,
                pane: 'labels'
            }).addTo(map);

            /* polygon kaltim */
            const geojson = L.geoJson(provinsi).addTo(map);
            // Marker 
            L.marker([-0.5017800563824011, 117.13930893505301]).addTo(map);


            map.setView({
                lat: 0.3923907,
                lng: 117.4408816
            }, 6);
        </script>
    @endpush
@endsection
