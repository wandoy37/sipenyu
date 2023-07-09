@extends('home.layouts.app')
@section('title', '')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="font-title-1">Peta Sebaran</h1>
                    <h4>Unit Pelaksana Teknis Dinas Pangan, Tanaman Pangan dan Hortikultura</h4>
                </div>
                <div class="col-lg-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            var map = L.map('map').setView([-0.416893, 117.178523], 7);

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        </script>
    @endpush
@endsection
