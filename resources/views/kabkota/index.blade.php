@extends('layouts.app')
@section('title', 'Kabupaten Kota')

@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Kabupaten Kota</h4>
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
            <a href="{{ route('kabkota.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                Kab Kota
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th>Kabupaten / Kota</th>
                                <th class="text-center">Kecamatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kabkotas as $kabkota)
                                <tr>
                                    <td class="text-center">{{ $kabkota->code }}</td>
                                    <td>{{ $kabkota->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('kecamatan.index') }}" class="text-dark">
                                            {{ $kabkota->kecamatans->count() }}
                                        </a>
                                    </td>
                                    <td width="15%" class="text-center">
                                        <form action="{{ route('kabkota.delete', $kabkota->code) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('kabkota.edit', $kabkota->code) }}" class="text-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="submit" class="ms-4 btn btn-link text-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tables').DataTable();
            });
        </script>
    @endpush
@endsection
