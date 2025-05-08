@extends('home.layouts.app')
@section('title', 'Layanan')

@section('content')
    <style>
        /* Product Custom */
        /* body {
                                                                                                                        background-color: mintcream;
                                                                                                                        display: flex;
                                                                                                                        align-items: center;
                                                                                                                        justify-content: center;
                                                                                                                        flex-direction: column;
                                                                                                                    } */
        .card {
            /* max-width: 30em; */
            flex-direction: row;
            background-color: #696969;
            border: 0;
            box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18);
            /* margin: 3em auto; */
        }

        .card.dark {
            color: #fff;
        }

        .card.card.bg-light-subtle .card-title {
            color: dimgrey;
        }

        .card img {
            max-width: 25%;
            margin: auto;
            padding: 0.5em;
            border-radius: 0.7em;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
        }

        .text-section {
            max-width: 60%;
        }

        .cta-section {
            max-width: 40%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cta-section .btn {
            padding: 0.3em 0.5em;
            /* color: #696969; */
        }

        .card.bg-light-subtle .cta-section .btn {
            background-color: #898989;
            border-color: #898989;
        }

        @media screen and (max-width: 475px) {
            .card {
                font-size: 0.9em;
            }
        }
    </style>
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
                    <img src="{{ asset('uptd/' . $uptd->thumbnail) }}" class="img-fluid" style="border-radius: 20px;"
                        alt="">
                </div>
                <div class="col-md-6">
                    <div class="my-3">
                        <h3>
                            <i class="fas fa-info"></i>
                            Informasi
                        </h3>
                        <article class="my-2">
                            {!! $uptd->keterangan !!}
                        </article>
                        <div class="list-group my-1">
                            <span class="list-group-item list-group-item-action">
                                <div class="d-flex w-100">
                                    <h5 class="mb-1 fw-bold">Alamat</h5>
                                </div>
                                <small>{{ $uptd->alamat }}</small>
                            </span>
                            <span class="list-group-item list-group-item-action">
                                <div class="d-flex w-100">
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
    </section>



    <section>
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h1 class="font-title-1">List Produk Layananan</h1>
                    <p>Informasi layanan milik UPTD PTPH Provinsi Kalimantan Timur</p>
                </div>
                @foreach ($uptd->products as $product)
                    <div class="col-lg-8">
                        <div class="card bg-light mt-4">
                            <img src="{{ asset('produk/' . $product->thumbnail) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="text-section">
                                    <h5 class="card-title fw-bold">{{ $product->title }}</h5>
                                    <p class="card-text">
                                        {!! $product->keterangan !!}
                                    </p>
                                </div>
                                <div class="cta-section">
                                    <div class="fw-bold">{{ $product->harga }}</div>
                                    <a href="{{ route('produk.pesan', $product->id) }}"
                                        class="btn btn-outline-success">Pesan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
