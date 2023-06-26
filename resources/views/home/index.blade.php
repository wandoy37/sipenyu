@extends('home.layouts.app')
@section('title', '')

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

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-4">
                <p>Provinsi Kalimantan Timur</p>
                <div class="row">
                    <div class="col-md-12">
                        <h3>List Kabupaten/Kota</h3>
                        <div class="form-group">
                            <label for="kabkota">Pilih Kabupaten/Kota</label>
                            <select name="kabkota" id="kabkota" class="form-control">
                                <option value="">-semua kabupaten/kota-</option>
                                @foreach ($kabkotas as $kabkota)
                                    <option value="{{ $kabkota->code }}">{{ $kabkota->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;" id="pilih-kecamatan">
                    <div class="col-md-12">
                        <h3>List Kecamatan</h3>
                        <div class="form-group">
                            <label for="kecamatan">Pilih Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <option value="">-semua kecamatan-</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;" id="pilih-kantor">
                    <div class="col-md-12">
                        <h3>List Kantor</h3>
                        <div class="form-group">
                            <label for="kantor">Pilih Kantor</label>
                            <select name="kantor" id="kantor" class="form-control">
                                <option value="">-semua kantor-</option>

                            </select>
                        </div>
                    </div>
                </div>
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
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script>
            var map = L.map('map').setView([-0.416893, 117.178523], 7);
            // var marker = L.marker([-0.416893, 117.178523]).addTo(map);

            var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var geojsonLayer = null;
            var info = L.control();
            info.onAdd = function(map) {
                this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
                this.update();
                return this._div;
            };
            // method that we will use to update the control based on feature properties passed
            info.update = function(props) {
                if (props != 'undefined' && props != undefined && props != null) {
                    this._div.innerHTML = '<h4>Informasi</h4>' +
                        '<b>Jumlah Kantor : ' + props.Jumlah_Kantor + '</b>' +
                        '<br/><b>Jumlah Pegawai : ' + props.Jumlah_Pegawai + '</b>';
                }

            };
            info.addTo(map);

            function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 5,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.7
                });
                if (layer.feature.properties != undefined) {

                    info.update(layer.feature.properties);
                }

            }

            function resetHighlight(e) {
                geojsonLayer.resetStyle(e.target);
                info.update();
            }

            function zoomToFeature(e) {
                map.fitBounds(e.target.getBounds());
            }

            
            $("#kabkota").on("change", function() {
                getKecamatan($(this).val());
            });

            //request ajax
            function getKecamatan(kode_kab_kota) {
                if (kode_kab_kota != "") {
                    $("#pilih-kecamatan").show();
                } else {
                    $("#pilih-kecamatan").hide();
                    return;
                }
                $.ajax({
                    url: "{{ url('ajax/kecamatan') }}/" + kode_kab_kota,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        var html = '<option value="">-semua kecamatan-</option>';
                        $.each(data, function(key, value) {
                            html += '<option value="' + value.code + '">' + value.name + '</option>';
                        });
                        $("#kecamatan").html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
                loadGeojson('{{ url('geojson/feature-kecamatan') }}/' + kode_kab_kota);
                getKantor($("#kabkota").val(), $("#kecamatan").val());
            }

            $("#kecamatan").on("change", function() {
                getKantor($("#kabkota").val(), $(this).val());
            });

            //request ajax
            function getKantor(kode_kab_kota, kode_kecamatan) {
                if (kode_kecamatan != "") {
                    $("#pilih-kantor").show();
                } else {
                    $("#pilih-kantor").hide();
                    return;
                }
                $.ajax({
                    url: "{{ url('ajax/kantor') }}/" + kode_kab_kota + "/" + kode_kecamatan,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        var html = '<option value="">-semua kantor-</option>';
                        $.each(data, function(key, value) {
                            html += '<option value="' + value.code + '">' + value.name + '</option>';
                        });
                        $("#kantor").html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }

            function loadGeojson(url) {
                $("#kabkota").prop("disabled", true);
                map.spin(true);
                if (geojsonLayer == null) {
                    geojsonLayer = new L.GeoJSON.AJAX(url, {
                        onEachFeature: function(feature, layer) {
                            // layer.bindPopup(
                            //     `<p>Kec : ${feature.properties.Name}</p><p>Kab/Kota : ${feature.properties.City}</p><p>Jumlah Kantor : ${feature.properties.Jumlah_Kantor}</p><p>Jumlah Pegawai : ${feature.properties.Jumlah_Pegawai}</p>`
                            //     );
                            layer.on({
                                mouseover: highlightFeature,
                                mouseout: resetHighlight,
                                click: zoomToFeature
                            });
                        }

                    });

                    geojsonLayer.on('data:loaded', function(e) {
                        $("#kabkota").prop("disabled", false);
                        map.spin(false);
                        //fly and zoom
                        map.fitBounds(geojsonLayer.getBounds());
                    });
                    geojsonLayer.addTo(map);
                } else {
                    geojsonLayer.refresh(url);
                }

            }
            loadGeojson('{{ url('geojson/feature-kabkota') }}');
        </script>
    @endpush
@endsection
