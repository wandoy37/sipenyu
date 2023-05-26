@extends('layouts.app')
@section('title', 'Kantor BPP')

@section('content')
    <div class="my-4">
        <h1>Edit | Kantor BPP</h1>
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
                <form action="{{ route('kantor.update', $kantor->code) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select" id="kabkota" name="kabkota_id">
                            <option value="">-pilih kabupaten-</option>
                            @foreach ($kabkotas as $kabkota)
                                @if (old($kabkota->id, $kantor->kabkota_id) == $kabkota->id)
                                    <option value="{{ $kabkota->id }}" selected>{{ $kabkota->name }}</option>
                                @else
                                    <option value="{{ $kabkota->id }}">{{ $kabkota->name }}</option>
                                @endif
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
                            value="{{ old('name', $kantor->name) }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat"
                            value="{{ old('alamat', $kantor->alamat) }}">
                    </div>
                    <div class="mb-3 float-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            var kode = document.getElementById('kabkota').value;
            var oldKecamatan = {{ $kantor->kecamatan_id }};
            // Show -select kecamatan-
            $('#kecamatan').empty();
            $('#kecamatan').append('<option>-pilih kecamatan-</option>');
            $.ajax({
                url: "{{ URL::to('/get-kecamatan') }}" + "/" + kode,
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        const kecamatan = data[i];
                        if (kecamatan.id == oldKecamatan) {
                            $('#kecamatan').append(
                                `<option value="${kecamatan.id}" selected >${kecamatan.name}</option>`);
                        } else {
                            $('#kecamatan').append(`<option value="${kecamatan.id}">${kecamatan.name}</option>`);
                        }
                    }
                }
            });

            // if select kabkota
            $("#kabkota").change(function() {
                var id = $(this).val();
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
