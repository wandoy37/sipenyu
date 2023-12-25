@extends('layouts.app')
@section('title', 'Kabupaten Kota')

@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Kabupaten Kota</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <span>
                        <i class="fa fa-bell"></i>
                    </span>
                </li>
            </ul>
        </div>

        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Nama</th>
                                <th>No. HP</th>
                                <th class="text-center">Pesan</th>
                                <th class="text-center">Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanans as $pesanan)
                                <tr class="text-center">
                                    <td>{{ $pesanan->nama }}</td>
                                    <td>{{ $pesanan->no_hp }}</td>
                                    <td>{{ $pesanan->message }}</td>
                                    <td>{{ $pesanan->produk->title }}</td>
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
