@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
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

        <div class="row">
            <div class="col-lg-12">
                <h1>Sistem Informasi Penyuluh Pertanian (SIPP)</h1>
                <hr>
                <a href="https://api.whatsapp.com/send/?phone=6282148722747" class="btn btn-warning btn-lg btn-block my-4">
                    <i class="fas fa-info-circle"></i>
                    Technical Support for WhatsApp
                </a>
            </div>
        </div>


        <div class="row row-card-no-pd">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-users text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Daftar Penyuluh</p>
                                    <h4 class="card-title">{{ $pegawais->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Daftar Kecamatan</p>
                                    <h4 class="card-title">{{ $kecamatans->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-layer-group text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Daftar Kantor BPP</p>
                                    <h4 class="card-title">{{ $kantors->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-title">Daftar Kecamatan</div>
                    </div>
                    <div class="card-body">
                        <table id="tabel_kecamatan" class="display table table-striped table-hover" cellspacing="1"
                            width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kab/Kota</th>
                                    <th>Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($kecamatans as $kecamatan)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $kecamatan->kabkota->name }}</td>
                                        <td>{{ $kecamatan->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Daftar Kantor BPP</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tabel_kantor_bpp" class="display table table-striped table-hover" cellspacing="1"
                            width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kantor BPP</th>
                                    <th>Alamat</th>
                                    <th>Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kantors as $kantor)
                                    <tr>
                                        <td class="text-center">{{ $kantor->code }}</td>
                                        <td>{{ $kantor->name }}</td>
                                        <td>{{ $kantor->alamat }}</td>
                                        <td>{{ implode(',', $kantor->kecamatans->pluck('name')->toArray()) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tabel_kecamatan').DataTable();
            });

            $(document).ready(function() {
                $('#tabel_kantor_bpp').DataTable();
            });
        </script>
    @endpush
@endsection
