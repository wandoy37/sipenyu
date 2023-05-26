@extends('layouts.app')
@section('title', 'Kantor BPP')

@section('content')
    <div class="my-4">
        <h1>Kantor BPP</h1>
        @include('flash-message')
    </div>

    <section class="my-2">
        <a href="{{ route('kantor.create') }}" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i>
            Kantor BPP
        </a>
    </section>

    <section class="my-4">
        <div class="card">
            <div class="card-body shadow">
                <table id="tables" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Kode</th>
                            <th>Kantor BPP</th>
                            <th>Kecamatan</th>
                            <th>Kab/Kota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kantors as $kantor)
                            <tr>
                                <td class="text-center">{{ $kantor->code }}</td>
                                <td>{{ $kantor->name }}</td>
                                <td>{{ $kantor->kecamatan->name }}</td>
                                <td>{{ $kantor->kabkota->name }}</td>
                                <td width="15%" class="text-center">
                                    <form action="{{ route('kantor.delete', $kantor->code) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <a href="{{ route('kantor.edit', $kantor->code) }}" class="text-warning">
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tables').DataTable();
            });
        </script>
    @endpush
@endsection
