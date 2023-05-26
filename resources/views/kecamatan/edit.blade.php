@extends('layouts.app')
@section('title', 'Kecamatan')

@section('content')
    <div class="my-4">
        <h1>Edit | Kecamatan</h1>
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
                <form action="{{ route('kecamatan.update', $kecamatan->code) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select class="form-select" name="kabkota_id" aria-label="Default select example">
                            <option selected>-pilih kabupaten-</option>
                            @foreach ($kabkotas as $kabkota)
                                @if (old($kabkota->id, $kecamatan->kabkota_id) == $kabkota->id)
                                    <option value="{{ $kabkota->code }}" selected>{{ $kabkota->name }}</option>
                                @else
                                    <option value="{{ $kabkota->code }}">{{ $kabkota->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" name="name" class="form-control" id="kecamatan" placeholder="Kecamatan"
                            value="{{ old('name', $kecamatan->name) }}">
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

@endsection
