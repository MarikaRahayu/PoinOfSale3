<div>
    <label>Gambar</label>
    <input type="file"
        name="foto"
        class="form-control @error('foto') is-invalid @enderror">

    @error('foto')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

<div>
    <label>Nama Produk</label><br>
    <input type="text" name="nama"
        class="form-control @error('nama') is-invalid @enderror"
        value="{{ old('nama' ?? '') }}">

    @error('nama')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div>
    <label>Harga Beli</label><br>
    <input type="number" name="purchase_price"
        class="form-control @error('purchase_price') is-invalid @enderror"
        value="{{ old('purchase_price' ?? '') }}">

    @error('purchase_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div>
    <label>Harga Jual</label><br>
    <input type="number" name="selling_price"
        class="form-control @error('selling_price') is-invalid @enderror"
        value="{{ old('selling_price' ?? '') }}">

    @error('selling_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div>
    <label>Stok</label><br>
    <input type="number" name="stock"
        class="form-control @error('stock') is-invalid @enderror"
        value="{{ old('stock' ?? '') }}">

    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-3" type="submit">Simpan</button>
<a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>