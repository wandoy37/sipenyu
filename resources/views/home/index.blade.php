@extends('home.layouts.app')
@section('title', '')

@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-4">
                <p>Provinsi Kalimantan Timur</p>
                <h3>List Kabupaten/Kota</h3>
                <div class="form-group">
                    <label for="kabkota">Kabupaten/Kota</label>
                    <select name="kabkota" id="kabkota" class="form-control">
                        <option value="">-pilih kabupaten-</option>
                        @foreach ($kabkotas as $kabkota)
                            <option value="{{ $kabkota->code }}">{{ $kabkota->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="overflow-scroll p-3 bg-light">
                    <p>Kabupaten</p>
                </div> --}}
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h3>
                            <i class="fas fa-map"></i>
                            Peta
                        </h3>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
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
