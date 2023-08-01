@extends('home.layouts.app')
@section('title', 'Layanan')

@section('content')
    <section>
        <div class="container">
            <div class="row my-4" style="padding-top: 25px;">
                <div class="col-lg-12">
                    <a href="{{ route('layanan') }}" class="text-decoration-none text-success fw-bold">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <h5>
                        Informasi penyedia Aset Properti Pemerintah Provinsi Kalimantan TImur
                    </h5>
                    <h1 class="font-title-1">{{ $uptd->title }}</h1>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/new-bppsdmp2023.jpg') }}" class="img-fluid" style="border-radius: 20px;"
                        alt="">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-green-two" style="color: #ffffff">
                            <i class="fas fa-info"></i>
                            Informasi
                        </div>
                        <div class="card-body">
                            {!! $uptd->keterangan !!}
                            <div class="list-group my-1">
                                <span class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold">Alamat</h5>
                                    </div>
                                    <small>{{ $uptd->alamat }}</small>
                                </span>
                                <span class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 fw-bold">No. Handphone / <i>Whatsapp</i></h5>
                                    </div>
                                    <a href="tel:{{ $uptd->no_hp }}" class="btn btn-outline-success"
                                        style="border-radius: 30px;">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                    <small>{{ $uptd->no_hp }}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="font-title-1">List Produk Layananan</h1>
                    <p>Informasi layanan milik UPTD BPPSDMP Provinsi Kalimantan Timur</p>
                </div>
                <div class="col-lg-12">
                    <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-between">
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('assets/img/asrama.png') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title title-layanan-1">Asrama</h5>
                                    <ul>
                                        <li>Fasilitas AC</li>
                                        <li>Fasilitas Kipas Angin</li>
                                    </ul>
                                </div>
                                <div class="mb-4 footer text-center mt-4">
                                    <h3 class="text-green">
                                        Rp 75.000
                                    </h3>
                                    <i>Per-Hari</i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('assets/img/mess.png') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title title-layanan-1">Mess</h5>
                                    <ul>
                                        <li>Fasilitas AC</li>
                                    </ul>
                                </div>
                                <div class="mb-4 footer text-center mt-4">
                                    <h3 class="text-green">
                                        Rp 125.000
                                    </h3>
                                    <i>Per-Hari</i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('assets/img/aula.png') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title title-layanan-1">Aula</h5>
                                    <ul>
                                        <li>Fasilitas AC</li>
                                    </ul>
                                </div>
                                <div class="mb-4 footer text-center mt-4">
                                    <h3 class="text-green">
                                        Rp 250.000
                                    </h3>
                                    <i>Per-Hari</i>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('assets/img/kelas.png') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title title-layanan-1">Kelas</h5>
                                    <ul>
                                        <li>Fasilitas AC</li>
                                    </ul>
                                </div>
                                <div class="mb-4 footer text-center mt-4">
                                    <h3 class="text-green">
                                        Rp 250.000
                                    </h3>
                                    <i>Per-Hari</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
