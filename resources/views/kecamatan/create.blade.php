@extends('layouts.app')
@section('title', 'Kecamatan')

@section('content')
    <div class="my-4">
        <h1>Tambah | Kecamatan</h1>
        @include('flash-message')
    </div>

    <section class="my-2">
        <a href="{{ route('kecamatan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-undo"></i>
            Kembali
        </a>
    </section>

    <section class="my-4">
        <div class="card">
            <div class="card-body shadow">
                <form action="{{ route('kecamatan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select class="form-select" name="kabkota_id" aria-label="Default select example">
                            <option selected>-pilih kabupaten-</option>
                            @foreach ($kabkotas as $kabkota)
                                <option value="{{ $kabkota->code }}">{{ $kabkota->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" name="name" class="form-control" id="kecamatan" placeholder="Kecamatan"
                            value="{{ old('name') }}">
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

@endsection
