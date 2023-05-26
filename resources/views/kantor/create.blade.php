@extends('layouts.app')
@section('title', 'Kantor BPP')

@section('content')
    <div class="my-4">
        <h1>Tambah | Kantor BPP</h1>
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
                        <select class="form-select" id="kabkota" name="kabkota_id">
                            <option value="">-pilih kabupaten-</option>
                            @foreach ($kabkotas as $kabkota)
                                <option value="{{ $kabkota->id }}">{{ $kabkota->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="kecamatan" name="kecamatan_id">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kantor" class="form-label">Kantor</label>
                        <input type="text" name="name" class="form-control" id="kantor" placeholder="Kantor"
                            value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat"
                            value="{{ old('alamat') }}">
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

    @push('scripts')
        <script>
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
                        for (let i = 0; i < data.length; i++) {
                            const kecamatan = data[i];
                            $('#kecamatan').append(
                                `<option value="${kecamatan.id}">${kecamatan.name}</option>`);
                        }
                    }
                });
            });
        </script>
    @endpush

@endsection
