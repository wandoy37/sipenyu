@extends('home.layouts.app')
@section('title', 'Layanan')

@section('content')
    <section>
        <div class="container">
            <div class="row my-4" style="padding-top: 25px;">
                <div class="col-lg-12">
                    <h5>
                        Informasi penyedia Aset Properti Pemerintah Provinsi Kalimantan TImur
                    </h5>
                    <h1 class="font-title-1">UPTD BPPSDMP</h1>
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
                            <span>UPTD Balai Penyuluhan dan Pengembangan Sumber Daya Manusia
                                Pertanian (BPPSDMP) Provinsi Kalimantan Timur</span>
                            <div class="my-4">
                                <span>Alamat</span>
                                <br>
                                <span>
                                    Jl. Thoyib Hadiwijaya No.36, Sempaja Selatan, Samarinda - Kalimantan Timur
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section style="background-color: #F6FFF6">
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="row">
                <div class="col-lg-12">
                    <p>Informasi penyedia Aset Properti milik UPTD BPPSDMP Provinsi Kalimantan TImur</p>
                    <h1 class="font-title-1">Aset Properti</h1>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-3 text-center my-4">
                    <img src="{{ asset('assets/img/asrama.png') }}" class="img-fluid" width="100%"
                        style="border-radius: 20px;" alt="">
                    <div class="info mt-4">
                        <span class="span-title">Asrama</span>
                    </div>
                </div>
                <div class="col-md-3 text-center my-4">
                    <img src="{{ asset('assets/img/mess.png') }}" class="img-fluid" width="100%"
                        style="border-radius: 20px;" alt="">
                    <div class="info mt-4">
                        <span class="span-title">Mess</span>
                    </div>
                </div>
                <div class="col-md-3 text-center my-4">
                    <img src="{{ asset('assets/img/aula.png') }}" class="img-fluid" width="100%"
                        style="border-radius: 20px;" alt="">
                    <div class="info mt-4">
                        <span class="span-title">Aula</span>
                    </div>
                </div>
                <div class="col-md-3 text-center my-4">
                    <img src="{{ asset('assets/img/kelas.png') }}" class="img-fluid" width="100%"
                        style="border-radius: 20px;" alt="">
                    <div class="info mt-4">
                        <span class="span-title">Kelas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="row">
                <div class="col-lg-12">
                    <p>Informasi penyedia Aset Properti milik UPTD BPPSDMP Provinsi Kalimantan TImur</p>
                    <h1 class="font-title-1">Daftar </h1>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td colspan="2">Larry the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

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
