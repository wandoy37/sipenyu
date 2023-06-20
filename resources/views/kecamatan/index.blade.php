@extends('layouts.app')
@section('title', 'Kecamatan')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Kecamatan</h4>
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
            <a href="{{ route('kecamatan.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                Kecamatan
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th>Kab/Kota</th>
                                <th>Kecamatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kecamatans as $kecamatan)
                                <tr>
                                    <td class="text-center">{{ $kecamatan->code }}</td>
                                    <td>{{ $kecamatan->kabkota->name }}</td>
                                    <td>{{ $kecamatan->name }}</td>
                                    <td width="15%" class="text-center">
                                        <form action="{{ route('kecamatan.delete', $kecamatan->code) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('kecamatan.edit', $kecamatan->code) }}" class="text-warning">
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
