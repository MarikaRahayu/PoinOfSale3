@extends('layouts.app')

@section('title', 'Tentang')

@section('content')

<style>
    .tentang-wrapper {
        min-height: calc(100vh - 80px);
        background: #fff5fa;
        padding: 50px 20px;
    }

    .tentang-card {
        max-width: 1000px;
        margin: auto;
        background: white;
        border-radius: 25px;
        padding: 45px;
        box-shadow: 0 10px 30px rgba(214, 51, 132, 0.15);
    }

    .tentang-title {
        color: #d63384;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .tentang-subtitle {
        color: #777;
        margin-bottom: 30px;
    }

    .tentang-img {
        width: 280px;
        height: 280px;
        object-fit: cover;
        border-radius: 20px;
        border: 5px solid #ffd6e9;
        box-shadow: 0 8px 20px rgba(214, 51, 132, 0.15);
    }

    .tentang-text {
        color: #555;
        line-height: 1.8;
        font-size: 16px;
    }

    .info-box {
        background: #fff0f6;
        border-radius: 15px;
        padding: 20px;
        margin-top: 25px;
    }

    .info-box h5 {
        color: #d63384;
        font-weight: bold;
    }

    .btn-pink {
        background: #d63384;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
    }

    .btn-pink:hover {
        background: #b52a70;
        color: white;
    }
</style>

<div class="tentang-wrapper">

    <div class="tentang-card">

        <div class="row align-items-center">

            {{-- FOTO --}}
            <div class="col-md-5 text-center mb-4 mb-md-0">

                <img
                    src="{{ asset ('images/pp.jpeg') }}"
                   
                    class="tentang-img"
                >

            </div>

            {{-- INFORMASI --}}
            <div class="col-md-7">

                <h1 class="tentang-title">
                    Tentang POS
                </h1>

                <p class="tentang-subtitle">
                    Sistem Point of Sale untuk membantu pengelolaan toko
                </p>

                <p class="tentang-text">
                    <strong>POS</strong> adalah aplikasi Point of Sale
                    yang dibuat untuk membantu proses pengelolaan produk,
                    stok, dan transaksi penjualan secara lebih mudah dan
                    terorganisir.
                </p>

                <p class="tentang-text">
                    Aplikasi ini memungkinkan pengguna untuk mengelola data
                    produk, melihat stok, mencatat transaksi penjualan, serta
                    memantau aktivitas penjualan melalui dashboard.
                </p>

                <div class="info-box">

                    <h5>
                        Informasi Aplikasi
                    </h5>

                    <p class="mb-1">
                        <strong>Nama:</strong> POS
                    </p>

                    <p class="mb-1">
                        <strong>Jenis:</strong> Point of Sale
                    </p>

                    <p class="mb-1">
                        <strong>Framework:</strong> Laravel
                    </p>

                    <p class="mb-1">
                        <strong>Database:</strong> MySQL
                    </p>

                    <p class="mb-0">
                        <strong>Fungsi:</strong> Produk, Stok dan Penjualan
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection