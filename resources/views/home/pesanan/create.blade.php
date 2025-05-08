@extends('home.layouts.app')
@section('title', 'Pesan Produk Layanan')

@section('content')
    <section>
        <div class="container">
            <div class="row my-4" style="padding-top: 25px;">
                <div class="col-lg-12">
                    <a href="{{ route('layanan.show', $product->uptd->slug) }}" class="btn btn-outline-success mb-4">
                        <i class="fas fa-arrow-left"></i>
                        Kembali</a>
                    <h5>
                        Form pemesanan
                    </h5>
                    <h1 class="font-title-1">Pesan Produk Layanan {{ $product->uptd->title }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row" style="margin-top: 50px;">
                    <div class="col-lg-6">
                        <img src="{{ asset('produk/' . $product->thumbnail) }}" class="img-fluid"
                            style="border-radius: 20px;" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pesan.produk', $product->id) }}" method="POST">
                                    @csrf
                                    <h3>Informasi Produk</h3>
                                    <hr>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Produk</span>
                                        <input type="text" class="form-control" value="{{ $product->title }}">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text">Keterangan Produk</span>
                                        <article class="mt-4" style="font-size: 16px;">
                                            {!! $product->keterangan !!}
                                        </article>
                                    </div>
                                    <hr>
                                    <h3>Form Pemesanan</h3>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">No Hp</label>
                                                <input type="text" name="no_hp" class="form-control">
                                            </div>
                                            <div class="col-sm-12 mt-4">
                                                <label class="form-label">Detail Pesanan</label>
                                                <textarea class="form-control" name="keterangan" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 clearfix">
                                        <button type="submit" class="btn btn-success float-end">Pesan Sekarang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
