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
                <div class="card">
                    <div class="card-body">
                        <table id="tables" class="display table table-striped table-hover" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th width="15%">Tanggal</th>
                                    <th>Nama</th>
                                    <th>Saran & Masukan</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($saran_masukan as $masukan)
                                    <tr>
                                        <td>{{ $masukan->created_at->format('d M Y') }}</td>
                                        <td>{{ $masukan->nama }}</td>
                                        <td>{{ $masukan->saran_masukan }}</td>
                                        {{-- <td width="15%" class="text-center">
                                            <form action="{{ route('pegawai.delete', $pagawai->code) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <a href="{{ route('pegawai.edit', $pagawai->code) }}" class="text-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="submit" class="ms-4 btn btn-link text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td> --}}
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
                $('#tables').DataTable();
            });
        </script>
    @endpush
@endsection
