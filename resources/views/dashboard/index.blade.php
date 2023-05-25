@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="my-4 text-center">
        <h1>(SIPENYU)</h1>
        <p>Sistem Informasi Penyuluhan</p>
    </div>
    <div class="card my-4">
        <div class="card-body">
            <h2>Selamat Datang !</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
