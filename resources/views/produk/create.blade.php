@extends('layouts.app')
@section('title', 'Produk')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Produk</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <span>
                        <i class="fab fa-product-hunt"></i>
                    </span>
                </li>
            </ul>
        </div>
        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i>
                Kembali
            </a>
        </section>

        <section class="my-2">
            <div class="card">
                <div class="card-header">
                    Produk {{ $uptd->title }}
                </div>
                <div class="card-body shadow">
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Produk
                                    </label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                    <input type="text" name="uptd" class="form-control" value="{{ $uptd->id }}"
                                        hidden>
                                    @error('title')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Harga
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="harga" class="form-control">
                                    </div>
                                    @error('harga')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                                    @error('satuan')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Thumbnail
                                    </label>
                                    <input type="file" name="thumbnail" class="form-control"
                                        value="{{ old('thumbnail') }}">
                                    @error('thumbnail')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>
                                        <span class="text-danger">*</span>
                                        keterangan
                                    </label>
                                    <br>
                                    @error('keterangan')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                    <textarea name="keterangan" id="summernote" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                </div>
                                <div class="mb-3 float-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $('#summernote').summernote({
                placeholder: 'Konten...',
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                tabsize: 2,
                height: 300
            });
        </script>
    @endpush
@endsection
