@extends('layouts.app')
@section('title', 'Kabupaten Kota')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah | Kabupaten Kota</h4>
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
    </div>

@endsection
