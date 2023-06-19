@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="my-4 text-center">
        <h1>(SIPENYU)</h1>
        <p>Sistem Informasi Penyuluhan</p>
    </div>
    <div class="card my-4">
        <div class="card-body">
            <h2>Selamat Datang !</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card my-4 shadow">
        <div class="card-body">
            <h3>
                <i class="fas fa-map"></i>
                Peta
            </h3>
            <div id="map"></div>
        </div>
    </div>

    @push('scripts')
        <script>
            var map = L.map('map').setView([0.1039772, 113.787918], 7);
            var marker = L.marker([-0.416893, 117.178523]).addTo(map);

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        </script>
    @endpush

@endsection
