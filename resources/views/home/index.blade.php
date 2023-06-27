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
        <div class="row my-2" id="detail-data" style="display: none;">
            <div class="col-lg-4">
                <h4>Detail Kantor:</h4>
                <ul id="detail-kantor">
                    <li></li>
                </ul>
            </div>
            <div class="col-lg-8" >
                <h4>Daftar Penyuluh:</h4>
                <table class="table" >
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>
                                Jenis
                            </th>
                        </tr>
                    </thead>
                    <tbody id="detail-pegawai">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script>
            let kantors = [];
            var map = L.map('map').setView([-0.416893, 117.178523], 7);
            var markers = new L.LayerGroup([])
            markers.addTo(map);
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
               
                var msg = '<h4>Informasi</h4>';
                if (props != 'undefined' && props != undefined && props != null) {
                    msg += '<p><b>Nama Daerah : ' + props.Name + '</b></p>';
                    if(props.Jumlah_Kecamatan != undefined){
                        msg += '<p><b>Jumlah Kecamatan : ' + props.Jumlah_Kecamatan + '</b></p>';
                    }
                    if(props.Jumlah_Kantor != undefined){
                        msg += '<p><b>Jumlah Kantor : ' + props.Jumlah_Kantor + '</b></p>';
                    }
                    if(props.Jumlah_Pegawai != undefined){
                        msg += '<p><b>Jumlah Penyuluh : ' + props.Jumlah_Pegawai + '</b></p>';
                    }
                    
                }
                this._div.innerHTML = msg;

            };
            info.addTo(map);

            function highlightFeature(e) {
                var layer = e.target;
                //console.log(layer);
                if (layer.feature != undefined && layer.feature.properties != undefined) {
                    layer.setStyle({
                        weight: 5,
                        color: '#666',
                        dashArray: '',
                        fillOpacity: 0.7
                    });
                    info.update(layer.feature.properties);
                } else if(layer.properties != undefined) {
                    info.update(layer.properties);
                }

            }

            function resetHighlight(e) {
                geojsonLayer.resetStyle(e.target);
                info.update();
            }

            function zoomToFeature(e) {
                //check if can getbounds
                if (e.target.getBounds != undefined) {
                    map.fitBounds(e.target.getBounds());
                } else if(e.target.properties != undefined ){
                    map.flyTo([e.target.properties.latitude, e.target.properties.longitude], 15);
                }
               
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
                $("#kecamatan").html("");
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
                if($(this).val() != ""){
                    loadGeojson('{{ url("geojson/feature-kecamatan") }}/' + $("#kabkota").val()+"/"+ $("#kecamatan").val());
                } else {
                    loadGeojson('{{ url('geojson/feature-kecamatan') }}/' + kode_kab_kota);
                }
                getKantor($("#kabkota").val(), $(this).val());
            });

            //request ajax
            function getKantor(kode_kab_kota, kode_kecamatan) {
                if (kode_kecamatan != "" && kode_kecamatan != null) {
                    $("#pilih-kantor").show();
                } else {
                    $("#pilih-kantor").hide();
                    return;
                }
                $("#kantor").html("");
                $.ajax({
                    url: "{{ url('ajax/kantor') }}/" + kode_kab_kota + "/" + kode_kecamatan,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        markers.clearLayers();
                        pegawais = []
                        var html = '<option value="">-semua kantor-</option>';
                        $.each(data, function(key, value) {
                            //add new value to kantors with code as key
                            kantors[value.code] = value;
                            var marker = L.marker([value.latitude, value.longitude]);
                            marker.properties = {
                                Name:value.name,
                                Jumlah_Pegawai:value.pegawais.length,
                                latitude:value.latitude,
                                longitude:value.longitude
                            }
                            
                            marker.on({
                                mouseover: highlightFeature,
                                mouseout: resetHighlight,
                                click: zoomToFeature
                            });

                            markers.addLayer(marker);

                            html += '<option data-latitude="'+value.latitude+'" data-longitude="'+value.longitude+'" value="' + value.code + '">' + value.name + '</option>';
                        });
                        $("#kantor").html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            }

            function loadGeojson(url) {
                $("#detail-data").hide();
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

            $("#kantor").change(function(){
                if($(this).val()!=''){
                    const kantor = kantors[$(this).val()];
                    $("#detail-data").show();
                    var kecamatansText = "";
                    for (let i = 0; i < kantor.kecamatans.length; i++) {
                        const kecamatan = kantor.kecamatans[i];
                        kecamatansText += '<span class="badge bg-primary mr-1">'+kecamatan.name+"</span> ";
                    }
                    $("#detail-kantor").html(`
                        <li>Nama : ${kantor.name}</li>
                        <li>Alamat : ${kantor.alamat}</li>
                        <li>Jumlah Pegawai : ${kantor.pegawais.length}</li>
                        <li>Kecamatan : ${kecamatansText}</li>
                    `);

                    var tbody = $("#detail-pegawai");
                    tbody.html('');
                    for (let i = 0; i < kantor.pegawais.length; i++) {
                        const pegawai = kantor.pegawais[i];
                        tbody.append(`
                            <tr>
                                <td>${i+1}</td>
                                <td>${pegawai.name}</td>
                                <td>${pegawai.type}</td>
                            </tr>
                        `);
                        
                    }
                    //scroll to bottom
                    $('html, body').animate({
                        scrollTop: $("#detail-data").offset().top
                    }, 1000);
                }
                
                var latitude = $(this).find(":selected").data("latitude");
                var longitude = $(this).find(":selected").data("longitude");
                map.flyTo([latitude, longitude], 15);
            });
        </script>
    @endpush
@endsection
