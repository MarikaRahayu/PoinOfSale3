@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')

<style>

    body {
        background: #fdf2f8;
    }

    .jenis-container {
        max-width: 1100px;
        margin: 45px auto;
        padding: 0 20px;
    }

    .jenis-header {
        margin-bottom: 18px;
    }

    .jenis-title {
        color: #be185d;
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .jenis-subtitle {
        color: #9ca3af;
        margin: 0;
        font-size: 14.5px;
    }

    .btn-tambah-wrapper {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 20px;
    }

    .btn-tambah {
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 16px rgba(219, 39, 119, .25);
        transition: all .2s ease;
    }

    .btn-tambah:hover {
        background: linear-gradient(135deg, #db2777, #be185d);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(219, 39, 119, .35);
    }

    .jenis-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(214, 51, 132, .1);
        border: 1px solid #fce7f3;
    }

    .jenis-card-header {
        background: linear-gradient(
            110deg,
            #ec4899,
            #f472b6
        );
        color: white;
        padding: 24px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .jenis-card-header h4 {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .jenis-card-header p {
        margin: 0;
        background: rgba(255,255,255,.2);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 600;
    }

    .jenis-card-body {
        padding: 28px;
    }

    .search-box {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }

    .search-box input {
        max-width: 450px;
        border: 2px solid #fbcfe8;
        border-radius: 12px;
        padding: 11px 16px;
        transition: .2s;
    }

    .search-box input:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 4px rgba(236, 72, 153, .12);
        outline: none;
    }

    .btn-cari {
        background: white;
        border: 2px solid #ec4899;
        color: #ec4899;
        border-radius: 12px;
        padding: 10px 22px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-cari:hover {
        background: #ec4899;
        color: white;
    }

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background: #fdf2f8;
        color: #be185d;
        border: none;
        padding: 14px 16px;
        font-weight: 700;
        font-size: 13.5px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #fdf2f8;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr {
        transition: background .15s;
    }

    .table tbody tr:hover {
        background: #fff7fb;
    }

    .badge-nomor {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fce7f3;
        color: #be185d;
        font-weight: 700;
        font-size: 13.5px;
    }

    .nama-jenis {
        font-weight: 600;
        color: #374151;
        display: inline-flex;
        align-items: center;
    }

    .badge-jumlah {
        background: #fdf2f8;
        color: #be185d;
        border: 1px solid #fbcfe8;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-edit {
        background: #fce7f3;
        color: #be185d;
        border: none;
        border-radius: 8px;
        padding: 7px 13px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: .2s;
    }

    .btn-edit:hover {
        background: #f9a8d4;
        color: #831843;
    }

    .btn-hapus {
        background: #ec4899;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 7px 13px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: .2s;
    }

    .btn-hapus:hover {
        background: #be185d;
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .pagination {
        margin-top: 25px;
    }

    .empty-state {
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 50px;
        color: #f9a8d4;
    }

    @media(max-width: 768px) {

        .jenis-title {
            font-size: 26px;
        }

        .btn-tambah-wrapper {
            justify-content: stretch;
        }

        .jenis-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-box {
            flex-direction: column;
        }

        .search-box input {
            max-width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }

</style>


<div class="jenis-container">

    {{-- HEADER --}}
    <div class="jenis-header">

        <h1 class="jenis-title">
            Jenis Produk
        </h1>

        <p class="jenis-subtitle">
            Kelola kategori atau jenis produk pada aplikasi POS
        </p>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
        </div>

    @endif


    {{-- TOMBOL TAMBAH (DI ATAS CARD) --}}
    <div class="btn-tambah-wrapper">

        <a href="{{ route('jenis-produk.create') }}"
           class="btn-tambah">

            <i class="bi bi-plus-lg"></i>
            + Tambah Jenis Produk

        </a>

    </div>


    {{-- CARD --}}
    <div class="jenis-card">

        {{-- CARD HEADER --}}
        <div class="jenis-card-header">

            <h4>
                <i class="bi bi-tags-fill"></i>
                Daftar Jenis Produk
            </h4>

            <p>
                Total : {{ $totalJenis }} Jenis
            </p>

        </div>


        <div class="jenis-card-body">

            {{-- SEARCH --}}
            <form action="{{ route('jenis-produk.index') }}"
                  method="GET"
                  class="search-box">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="🔎 Cari nama jenis produk..."
                >

                <button type="submit"
                        class="btn-cari">

                    Cari

                </button>

            </form>


            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th style="width: 80px;">
                                No
                            </th>

                            <th>
                                Nama Jenis Produk
                            </th>

                            <th style="width: 180px;">
                                Jumlah Produk
                            </th>

                            <th style="width: 180px;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($jenisProduk as $item)

                            <tr>

                                {{-- NO --}}
                                <td>

                                    <span class="badge-nomor">

                                        {{ $jenisProduk->firstItem() + $loop->index }}

                                    </span>

                                </td>


                                {{-- NAMA --}}
                                <td>

                                    <span class="nama-jenis">

                                        <i class="bi bi-tag-fill text-danger me-2"></i>

                                        {{ $item->nama }}

                                    </span>

                                </td>


                                {{-- JUMLAH PRODUK --}}
                                <td>

                                    <span class="badge-jumlah">

                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $item->produk()->count() }} Produk

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <a href="{{ route('jenis-produk.edit', $item->id) }}"
                                       class="btn-edit">

                                        <i class="bi bi-pencil-fill"></i>
                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('jenis-produk.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus jenis produk ini?')">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn-hapus">

                                            <i class="bi bi-trash-fill"></i>
                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center empty-state">

                                    <i class="bi bi-tags"></i>

                                    <p class="mt-3 mb-0 text-muted">

                                        Belum ada jenis produk.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            {{ $jenisProduk->links() }}

        </div>

    </div>

</div>

@endsection