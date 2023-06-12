@extends('layouts.app')
@section('title', 'Tenaga Kerja')

@section('content')
    <div class="my-4">
        <h1>Edit | Tenaga Kerja</h1>
        @include('flash-message')
    </div>

    <section class="my-2">
        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-undo"></i>
            Kembali
        </a>
    </section>

    <section class="my-4">
        <div class="card">
            <div class="card-body shadow">
                <form action="{{ route('pegawai.update', $pegawai->code) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" id="nama" placeholder="Nama Pegawai"
                            value="{{ old('name', $pegawai->name) }}">
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="role" name="role">
                            <option value="">-pilih role-</option>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}"
                                    {{ old('role', $pegawai->role) == $key ? 'selected' : null }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="kantor" name="kantor">
                            <option value="">-pilih kantor-</option>
                            @foreach ($kantors as $kantor)
                                @if (old($kantor->id, $pegawai->kantor_id) == $kantor->id)
                                    <option value="{{ $kantor->id }}" selected>{{ $kantor->name }}</option>
                                @else
                                    <option value="{{ $kantor->id }}">{{ $kantor->name }}</option>
                                @endif
                            @endforeach
                        </select>
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