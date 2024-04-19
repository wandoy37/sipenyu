@extends('layouts.app')
@section('title', 'Pengguna')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Pengguna</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengguna.index') }}">Pengguna</a>
                </li>
            </ul>
        </div>

        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <a href="{{ route('pengguna.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i>
                Pengguna
            </a>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td width="25%" class="text-center">
                                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('pengguna.edit', $user->id) }}" class="text-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            @if (Auth::id() != $user->id)
                                                <button type="submit" class="btn btn-link text-danger"
                                                    onclick="return confirm('Anda yakin ingin menghapus pengguna ini? pengguna yang di hapus akan menghapus postingan')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-link text-danger" hidden
                                                    onclick="return confirm('Anda yakin ingin menghapus pengguna ini? pengguna yang di hapus akan menghapus postingan')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
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
        </script>
    @endpush
@endsection
