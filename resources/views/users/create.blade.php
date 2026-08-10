@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0 rounded-4">

                <!-- Header -->
                <div class="card-header text-center text-dark"
                    style="background:#f8bbd0;">

                    <h2 class="fw-bold mb-1">Tambah User</h2>

                    <small>Lengkapi data pengguna baru</small>

                </div>

                <div class="card-body p-4">

                    <form action="{{ route('users.store') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="fw-bold" style="color:#ec407a;">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="fw-bold" style="color:#ec407a;">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email">

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="fw-bold" style="color:#ec407a;">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password">

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-4">

                            <label class="fw-bold" style="color:#ec407a;">
                                Role
                            </label>

                            <select
                                name="role_id"
                                class="form-select @error('role_id') is-invalid @enderror">

                                <option value="">-- Pilih Role --</option>

                                @foreach($roles as $role)

                                    <option value="{{ $role->id }}">

                                        {{ ucfirst($role->name) }}

                                    </option>

                                @endforeach

                            </select>

                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="d-flex justify-content-between">

                            <a href="{{ route('users.index') }}"
                               class="btn"
                               style="background:#f8bbd0;color:#ad1457;">

                                ← Kembali

                            </a>

                            <button
                                type="submit"
                                class="btn text-white"
                                style="background:#ec407a;">

                                 Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection