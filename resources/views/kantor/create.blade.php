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


    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('#kabkota').select2({
                placeholder:"-pilih kabupaten-"
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
                            $('#kecamatan').append(`<option value="${kecamatan.id}">${kecamatan.name}</option>`);
                        }
                        //select2 multiple
                        $('#kecamatan').select2();
                    }
                });
            });
        </script>
    @endpush

@endsection
