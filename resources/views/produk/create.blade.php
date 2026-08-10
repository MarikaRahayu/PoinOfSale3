@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h4 class="mb-4">Tambah Produk</h4>

    <form action="{{ route('produk.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- FOTO --}}
        <div class="mb-3">
            <label for="foto" class="form-label">
                Foto
            </label>

            <input
                type="file"
                name="foto"
                id="foto"
                accept="image/*"
                onchange="previewFoto(event)"
                class="form-control @error('foto') is-invalid @enderror"
            >

            @error('foto')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            {{-- Preview Foto --}}
            <div class="mt-3 text-center">
                <img
                    id="preview"
                    src=""
                    alt="Preview Foto"
                    class="img-thumbnail"
                    style="
                        display:none;
                        width:220px;
                        height:220px;
                        object-fit:cover;
                    "
                >
            </div>
        </div>


        {{-- JENIS PRODUK --}}
        <div class="mb-3">

            <label for="jenis_produk_id" class="form-label">
                Jenis Produk
            </label>

            <select
                name="jenis_produk_id"
                id="jenis_produk_id"
                class="form-control @error('jenis_produk_id') is-invalid @enderror"
                required
            >

                <option value="">
                    -- Pilih Jenis Produk --
                </option>

                {{-- Data diambil langsung dari tabel jenis_produk --}}
                @foreach ($jenisProduk as $jenis)

                    <option
                        value="{{ $jenis->id }}"
                        {{ old('jenis_produk_id') == $jenis->id ? 'selected' : '' }}
                    >
                        {{ $jenis->nama }}
                    </option>

                @endforeach

            </select>

            @error('jenis_produk_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- NAMA PRODUK --}}
        <div class="mb-3">

            <label for="nama" class="form-label">
                Nama Produk
            </label>

            <input
                type="text"
                name="nama"
                id="nama"
                value="{{ old('nama') }}"
                class="form-control @error('nama') is-invalid @enderror"
                placeholder="Masukkan nama produk"
                required
            >

            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- HARGA BELI --}}
        <div class="mb-3">

            <label for="harga_beli" class="form-label">
                Harga Beli
            </label>

            <input
                type="number"
                name="harga_beli"
                id="harga_beli"
                value="{{ old('harga_beli') }}"
                class="form-control @error('harga_beli') is-invalid @enderror"
                placeholder="Masukkan harga beli"
                min="0"
                required
            >

            @error('harga_beli')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- HARGA JUAL --}}
        <div class="mb-3">

            <label for="harga_jual" class="form-label">
                Harga Jual
            </label>

            <input
                type="number"
                name="harga_jual"
                id="harga_jual"
                value="{{ old('harga_jual') }}"
                class="form-control @error('harga_jual') is-invalid @enderror"
                placeholder="Masukkan harga jual"
                min="0"
                required
            >

            @error('harga_jual')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- STOK --}}
        <div class="mb-3">

            <label for="stok" class="form-label">
                Stok
            </label>

            <input
                type="number"
                name="stok"
                id="stok"
                value="{{ old('stok') }}"
                class="form-control @error('stok') is-invalid @enderror"
                placeholder="Masukkan jumlah stok"
                min="0"
                required
            >

            @error('stok')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- BUTTON --}}
        <div class="d-flex gap-2">

            <button
                type="submit"
                class="btn btn-success"
            >
                Simpan
            </button>

            <a
                href="{{ route('produk.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </div>

    </form>

</div>


{{-- PREVIEW FOTO --}}
<script>
    function previewFoto(event) {

        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {

            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);

        } else {

            preview.src = '';
            preview.style.display = 'none';

        }
    }
</script>

@endsection