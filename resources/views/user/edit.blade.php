@extends('layouts.app')
@section('title', 'Pengguna')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit | Pengguna</h4>
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
                    <a href="{{ route('pengguna.index') }}">Pengguna</a>
                </li>
            </ul>
        </div>

        <div class="my-4">
            @include('flash-message')
        </div>

        <section class="my-2">
            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i>
                Kembali
            </a>
        </section>

        <section class="my-4">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    @error('name')
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <input type="text" name="name" class="form-control" id="nama"
                                        placeholder="nama" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    @error('username')
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <input type="text" name="username" class="form-control" id="username"
                                        placeholder="username" value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    @error('email')
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="email" value="{{ old('email', $user->username) }}">
                                </div>
                                @if (Auth::user()->role == 'admin')
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        @error('role')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation"></i>
                                                {{ $message }}
                                            </span>
                                        @enderror
                                        <select class="form-control" name="role" aria-label="Default select example">
                                            <option selected>-pilih role-</option>
                                            <option value="admin"
                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                admin
                                            </option>
                                            <option value="operator"
                                                {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>operator
                                            </option>
                                        </select>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    @error('password')
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <div class="input-icon" id="show_hide_password">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="password" value="{{ old('password') }}">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                    @error('password_confirmation')
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation"></i>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <div class="input-icon" id="show_hide_confirmation">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="password_confirmation" placeholder="password_confirmation"
                                            value="{{ old('password_confirmation') }}">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3 float-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sync"></i>
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#show_hide_confirmation span").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_confirmation input').attr("type") == "text") {
                    $('#show_hide_confirmation input').attr('type', 'password');
                    $('#show_hide_confirmation i').addClass("fa-eye-slash");
                    $('#show_hide_confirmation i').removeClass("fa-eye");
                } else if ($('#show_hide_confirmation input').attr("type") == "password") {
                    $('#show_hide_confirmation input').attr('type', 'text');
                    $('#show_hide_confirmation i').removeClass("fa-eye-slash");
                    $('#show_hide_confirmation i').addClass("fa-eye");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password span").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
@endpush
