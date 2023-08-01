@extends('layouts.app')
@section('title', 'Kabupaten Kota')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Daftar UPTD</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <span>
                        <i class="fas fa-building"></i>
                    </span>
                </li>
            </ul>
        </div>
        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <a href="{{ route('daftar.uptd.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i>
                Kembali
            </a>
        </section>

        <section class="my-2">
            <div class="card">
                <div class="card-body shadow">
                    <form action="{{ route('daftar.uptd.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Unit Pelayanan / UPTD
                                    </label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Alamat
                                    </label>
                                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="text-danger">*</span>
                                        Nomor HP / WhatsApp <i>(yang dapat dihubungi)</i>
                                    </label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
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
