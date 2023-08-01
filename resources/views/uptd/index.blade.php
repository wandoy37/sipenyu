@extends('layouts.app')
@section('title', 'Daftar UPTD')

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
            <a href="{{ route('daftar.uptd.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                UPTD
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th width="20%">UPTD</th>
                                <th width="15%">email</th>
                                <th>No. HP</th>
                                <th>Thumbnail</th>
                                <th>Total Layanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uptds as $uptd)
                                <tr class="text-center">
                                    <td>{{ $uptd->title }}</td>
                                    <td>{{ $uptd->email }}</td>
                                    <td>{{ $uptd->no_hp }}</td>
                                    <td>
                                        <img src="{{ asset('uptd/' . $uptd->thumbnail) }}" class="img-thumbnail"
                                            width="50%" alt="">
                                    </td>
                                    <td>-total layanan-</td>
                                    <td width="15%">
                                        <form id="form-delete-{{ $uptd->id }}"
                                            action="{{ route('daftar.uptd.delete', $uptd->slug) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('daftar.uptd.edit', $uptd->slug) }}" class="text-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="submit" class="ms-4 btn btn-link text-danger"
                                                onclick="btnDelete( {{ $uptd->id }} )">
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
