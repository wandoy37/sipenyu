@extends('layouts.app')
@section('title', 'Api Token')

@section('content')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Api Token</h4>
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

        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <form action="{{ route('api-token.store') }}" method="POST">
                @csrf
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-plus"></i>
                    Token Baru
                </button>
            </form>
        </section>

        <section class="my-4">
            <div class="card">
                <div class="card-body shadow">
                    <table id="tables" class="display table table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Client Code</th>
                                <th>Api Token</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apiTokens as $apiToken)
                                <tr>
                                    <td>{{ $apiToken->client_code }}</td>
                                    <td>{{ $apiToken->api_token }}</td>

                                    <td class="d-flex align-items-center">
                                        <form action="{{ route('api-token.update', $apiToken->id) }}" method="POST"
                                            class="mx-1">
                                            @csrf @method('PUT')

                                            <button type="submit" class="btn-warning btn btn-sm">
                                                Reset <i class="fas fa-recycle"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('api-token.delete', $apiToken->id) }}" method="POST"
                                            class="mx-1">
                                            @csrf @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus <i class="fas fa-trash"></i>
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
        </script>
    @endpush
@endsection
