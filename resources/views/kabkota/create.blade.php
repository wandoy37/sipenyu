@extends('layouts.app')
@section('title', 'Kabupaten Kota')

@section('content')
    <div class="my-4">
        <h1>Tambah | Kabupaten Kota</h1>
        @include('flash-message')
    </div>

    <section class="my-2">
        <a href="{{ route('kabkota.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-undo"></i>
            Kembali
        </a>
    </section>

    <section class="my-2">
        <div class="card">
            <div class="card-body shadow">
                <form action="{{ route('kabkota.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nameKabKota" class="form-label">Kabupaten / Kota</label>
                        <input type="text" name="name" class="form-control" id="nameKabKota"
                            placeholder="Kabupaten / Kota" value="{{ old('name') }}">
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
