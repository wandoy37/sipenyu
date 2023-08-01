@extends('home.layouts.app')
@section('title', 'Layanan')

@section('content')
    <section>
        <div class="container">
            <div class="row my-4" style="padding-top: 25px;">
                <div class="col-lg-12">
                    <h5>
                        Informasi Pelayanan UPTD pada Dinas Pangan, Tanaman Pangan, dan Hortikultura Provinsi Kalimantan
                        Timur
                    </h5>
                    <h1 class="font-title-1">Layanan UPTD</h1>
                </div>
            </div>
            <div class="container text-center">
                <div class="row justify-content-md-center" style="margin-top: 50px;">
                    @foreach ($uptds as $uptd)
                        <div class="col-md-3">
                            <div class="">
                                <img src="{{ asset('uptd/' . $uptd->thumbnail) }}" class="img-fluid"
                                    style="border-radius: 20px;" alt="">
                            </div>
                            <div class="my-4">
                                <h3 class="font-title-2" style="color: #013220">{{ $uptd->title }}</h3>
                                <a href="{{ route('layanan.show', $uptd->slug) }}" class="btn btn-outline-success"
                                    style="border-radius: 20px;">Lihat Layanan</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
