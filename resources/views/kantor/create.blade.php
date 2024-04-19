@extends('layouts.app')
@section('title', 'Kantor BPP')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah | Kantor BPP</h4>
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

        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <a href="{{ route('kantor.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i>
                Kembali
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <form action="{{ route('kantor.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kabkota">
                                Pilih Kabupaten/Kota
                            </label>
                            <select class="form-control" id="kabkota" name="kabkota_id">
                                <option value="" disabled selected>-pilih kabupaten-</option>
                                @foreach ($kabkotas as $kabkota)
                                    <option value="{{ $kabkota->id }}">{{ $kabkota->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan">
                                Pilih Kecamatan
                            </label>
                            <select class="form-control" id="kecamatan" name="kecamatan_id[]" multiple>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kantor" class="form-label">Nama Kantor</label>
                            <input type="text" name="name" class="form-control" id="kantor" placeholder="Kantor..."
                                value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat..."
                                value="{{ old('alamat') }}">
                        </div>
                        {{-- <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label for="marker" class="form-label">Marker</label>
                                <textarea class="form-control" id="marker" name="marker" rows="3">{{ old('marker') }}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="polygon" class="form-label">Polygon</label>
                                <textarea class="form-control" id="polygon" name="polygon" rows="3">{{ old('polygon') }}</textarea>
                            </div>
                        </div> --}}
                        <div class="mb-3">
                            <label for="" class="form-label">Pilih Lokasi/Koordinat</label>
                            <div id="map" style="height:70vh;width:100%;"></div>
                            <input type="hidden" name="latitude" id="latitude" value="{{old('latitude')}}">
                            <input type="hidden" name="longitude" id="longitude" value="{{old('longitude')}}">
                        </div>
                        <div class="mb-3 float-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>

    @push('styles')
        <style>
            .info {
                padding: 6px 8px;
                font: 14px/16px Arial, Helvetica, sans-serif;
                background: white;
                background: rgba(255, 255, 255, 0.8);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                border-radius: 5px;
            }
        </style>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.6.1/dist/geosearch.css" />
    @endpush

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://unpkg.com/leaflet-geosearch@3.6.1/dist/geosearch.umd.js"></script>
        <script>
            $('#kabkota').select2({
                placeholder: "-pilih kabupaten-"
            });
            $('#kecamatan').select2();
            $("#kabkota").change(function() {
                var id = $(this).val();
                var url = "{{ URL::to('/get-kecamatan') }}" + "/" + id;
                $('#kecamatan').empty();
                $('#kecamatan').append('<option>-pilih kecamatan-</option>');
                $.ajax({
                    url: "{{ URL::to('/get-kecamatan') }}" + "/" + id,
                    method: "GET",
                    dataType: 'json',
                    success: function(data) {
                        //delete select2
                        $('#kecamatan').select2('destroy');
                        for (let i = 0; i < data.length; i++) {
                            const kecamatan = data[i];
                            $('#kecamatan').append(
                                `<option value="${kecamatan.id}">${kecamatan.name}</option>`);
                        }
                        //select2 multiple
                        $('#kecamatan').select2();
                    }
                });
            });

            var pin;
            var map = L.map('map').setView([-0.416893, 117.178523], 7);
            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var info = L.control();

            map.on('click', function(ev) {
                $('#latitude').val(ev.latlng.lat);
                $('#longitude').val(ev.latlng.lng);
                info.update(ev.latlng);
                if (typeof pin == "object") {
                    pin.setLatLng(ev.latlng);
                } else {
                    pin = L.marker(ev.latlng, {
                        riseOnHover: true,
                        draggable: true
                    });
                    pin.addTo(map);
                    pin.on('drag', function(ev) {
                        $('#latitude').val(ev.latlng.lat);
                        $('#longitude').val(ev.latlng.lng);
                    });
                }
            });


            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
                this.update();
                return this._div;
            };
            // method that we will use to update the control based on feature properties passed
            info.update = function(props) {

                var msg = '<h4>Koordinat</h4>';
                if (props != 'undefined' && props != undefined && props != null) {
                    msg += '<b>Latitude : </b>' + props.lat + '<br>';
                    msg += '<b>Longitude : </b>' + props.lng + '<br>';

                }
                this._div.innerHTML = msg;

            };
            info.addTo(map);



            const search = new GeoSearch.GeoSearchControl({
                position: 'topleft',
                provider: new GeoSearch.OpenStreetMapProvider(),
                
                showMarker: true,
                marker: {
                    draggable: false,
                },
                maxMarker: 1,
                autoClose: true,
                autoComplete: true,
                retainZoomLevel: true,
                maxSuggestions: 5,
                keepResult: true,
            });

            map.addControl(search);

            map.on('geosearch/showlocation', function(result) {
                $('#latitude').val(result.location.y);
                $('#longitude').val(result.location.x);
                info.update({
                    lat: result.location.y,
                    lng: result.location.x
                });
            });
        </script>
    @endpush

@endsection
