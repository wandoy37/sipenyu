@extends('layouts.app')
@section('title', 'Tenaga Kerja')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah | Tenaga Kerja</h4>
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
            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i>
                Kembali
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <form action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" id="nama"
                                placeholder="Nama Pegawai" value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <select class="form-control" id="role" name="role">
                                <option value="">-pilih role-</option>
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : null }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-control" id="kantor" name="kantor">
                                <option value="">-pilih kantor-</option>
                                @foreach ($kantors as $kantor)
                                    <option value="{{ $kantor->id }}" {{ old('kantor') == $key ? 'selected' : null }}>
                                        {{ $kantor->name }}</option>
                                @endforeach
                            </select>
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
