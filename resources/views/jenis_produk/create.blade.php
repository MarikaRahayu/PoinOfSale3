@extends('layouts.app')

@section('title', 'Tambah Jenis Produk')

@section('content')

<style>

    body {
        background: #fff5fa;
    }

    .form-container {
        max-width: 700px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .form-card {
        background: white;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(214, 51, 132, .12);
    }

    .form-title {
        color: #d63384;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #444;
    }

    .form-control {
        border: 2px solid #f8b4d4;
        border-radius: 10px;
        padding: 12px;
    }

    .form-control:focus {
        border-color: #e91e63;
        box-shadow: 0 0 0 3px rgba(233, 30, 99, .1);
    }

    .btn-simpan {
        background: #e91e63;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px 22px;
        font-weight: 600;
    }

    .btn-simpan:hover {
        background: #c2185b;
        color: white;
    }

    .btn-kembali {
        background: #6c757d;
        color: white;
        border-radius: 10px;
        padding: 11px 22px;
        text-decoration: none;
        font-weight: 600;
    }

</style>


<div class="form-container">

    <div class="form-card">

        <h2 class="form-title">
            <i class="bi bi-tag-fill"></i>
            Tambah Jenis Produk
        </h2>


        <form action="{{ route('jenis-produk.store') }}"
              method="POST">

            @csrf


            <div class="mb-4">

                <label class="form-label">
                    Nama Jenis Produk
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror"
                    placeholder="Contoh: Makanan"
                    required
                >

                @error('nama')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <button type="submit"
                    class="btn-simpan">

                <i class="bi bi-save-fill"></i>
                Simpan

            </button>


            <a href="{{ route('jenis-produk.index') }}"
               class="btn-kembali">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection