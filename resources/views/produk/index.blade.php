@extends('layouts.app')
@section('title', 'Produk UPTD')

@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Produk UPTD</h4>
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

        {{-- <section class="my-2">
            <a href="{{ route('daftar.uptd.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                UPTD
            </a>
        </section> --}}

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th width="20%">Produk</th>
                                <th width="15%">Harga</th>
                                <th>Satuan</th>
                                <th>UPTD</th>
                                <th>Thumbnail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="text-center">
                                    <td>{{ $product->title }}</td>
                                    <td>Rp {{ $product->harga }}</td>
                                    <td>{{ $product->satuan }}</td>
                                    <td>
                                        <img src="{{ asset('produk/' . $product->thumbnail) }}" class="img-thumbnail"
                                            width="50%" alt="">
                                    </td>
                                    <td>{{ $product->uptd->title }}</td>
                                    <td width="25%">
                                        <form id="form-delete-{{ $product->id }}"
                                            action="{{ route('produk.delete', $product->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('produk.edit', $product->id) }}" class="text-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="submit" class="ms-4 btn btn-link text-danger"
                                                onclick="btnDelete( {{ $product->id }} )">
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

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tables').DataTable();
            });

            function btnDelete(id) {
                swal({
                    title: 'Apa anda yakin?',
                    type: 'warning',
                    buttons: {
                        confirm: {
                            text: 'Ya, hapus sekarang',
                            className: 'btn btn-success'
                        },
                        cancel: {
                            visible: true,
                            className: 'btn btn-danger'
                        }
                    }
                }).then((Delete) => {
                    if (Delete) {
                        $('#form-delete-' + id).submit();
                    } else {
                        swal.close();
                    }
                });
            }
        </script>
    @endpush
@endsection
