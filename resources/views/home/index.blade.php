@extends('home.layouts.app')
@section('title', '')

@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-4">
                <p>Provinsi Kalimantan Timur</p>
                <h3>List Kabupaten/Kota</h3>
                <div class="form-group">
                    <label for="kabkota">Kecamatan per Kabupaten/Kota</label>
                    <select name="kabkota" id="kabkota" class="form-control">
                        <option value="">-semua kabupaten/kota-</option>
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
            var map = L.map('map').setView([-0.416893, 117.178523], 7);
            var marker = L.marker([-0.416893, 117.178523]).addTo(map);

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var geojsonLayer = null;
            $("#kabkota").on("change",function(){
                if($(this).val() != ""){
                    var url = '{{ url("feature-kecamatan") }}/'+$(this).val();
                    loadAllKecamatan(url);
                } else {
                    loadAllKecamatan('{{ url("feature-kecamatan") }}');
                }
            });

            function loadAllKecamatan(url) {
                $("#kabkota").prop("disabled",true);
                map.spin(true);
                if(geojsonLayer==null){
                    geojsonLayer = new L.GeoJSON.AJAX(url, {
                        onEachFeature: function(feature, layer) {
                            layer.bindPopup(`<p>Kec : ${feature.properties.Name}</p><p>Kab/Kota : ${feature.properties.City}</p><p>Jumlah Kantor : ${feature.properties.Jumlah_Kantor}</p><p>Jumlah Pegawai : ${feature.properties.Jumlah_Pegawai}</p>`);
                        }
                        
                    });
                    
                    geojsonLayer.on('data:loaded', function (e) {
                        $("#kabkota").prop("disabled",false);
                        map.spin(false);
                        //fly and zoom
                        map.fitBounds(geojsonLayer.getBounds());
                    });
                    geojsonLayer.addTo(map);
                } else {
                    geojsonLayer.refresh(url);
                }
                
            }
            loadAllKecamatan('{{ url("feature-kecamatan") }}');
        </script>
    @endpush
@endsection
