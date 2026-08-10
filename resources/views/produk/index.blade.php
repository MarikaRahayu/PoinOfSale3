@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<style>

body {
    background: #fff0f6;
}


/* Container */
.product-container {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(214,51,132,0.15);
}


/* Judul */
.product-title {
    color: #d63384;
    font-weight: 700;
}


/* Total Produk */
.total-box {

    background:#fff0f6;
    border:2px solid #ffc1dc;
    padding:15px 20px;
    border-radius:15px;
    color:#d63384;
    font-weight:bold;

}



/* Tombol tambah */
.btn-tambah {
    background: #ff69b4;
    color: white;
    border: none;
}

.btn-tambah:hover {
    background: #e7549c;
    color: white;
}



/* Search */
.form-control {
    border: 2px solid #ffc1dc;
}

.form-control:focus {
    border-color: #ff69b4;
    box-shadow: 0 0 5px #ff69b4;
}



/* Tombol cari */
.btn-cari {
    border-color: #ff69b4;
    color: #d63384;
}

.btn-cari:hover {
    background: #ff69b4;
    color:white;
}



/* Tabel */
.table {
    overflow:hidden;
    border-radius:15px;
}


.table thead th {

    background:#d63384 !important;
    color:white;
    text-align:center;

}


.table tbody tr:hover {

    background:#fff0f6;

}



/* Foto */
.img-thumbnail {

    border:3px solid #ffb6c1;
    border-radius:12px;

}



/* Tombol edit */
.btn-edit {

    background:#ffc1dc;
    color:#8b1e52;
    border:none;

}


.btn-edit:hover {

    background:#ff99c2;
    color:white;

}



/* Tombol hapus */
.btn-hapus {

    background:#ff4d88;
    color:white;
    border:none;

}


.btn-hapus:hover {

    background:#d6336c;

}



/* Pagination */
.pagination .page-link {

    color:#d63384;

}


.pagination .active .page-link {

    background:#d63384;
    border-color:#d63384;

}


</style>





<div class="container mt-5">


<div class="product-container">





<h1 class="product-title mb-2">

    Halaman Produk

</h1>





{{-- TOTAL PRODUK & SISA STOK --}}

<div class="d-flex gap-3 mb-4 flex-wrap">

    <div class="total-box">
        Total Produk : {{ $products->total() }} Produk
    </div>

</div>







@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif






@if(session('error'))

<div class="alert alert-danger">

    {{ session('error') }}

</div>

@endif








{{-- TAMBAH PRODUK --}}

@if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')
<div class="mb-3">


<a href="{{ route('produk.create') }}"
   class="btn btn-tambah btn-sm">


+ Tambah Produk


</a>


</div>
@endif







{{-- SEARCH --}}

<form action="{{ route('produk.index') }}"
      method="GET"
      class="mb-4">


<div class="d-flex gap-2">



<input type="text"
       name="search"
       class="form-control"
       placeholder="Cari nama produk..."
       value="{{ request('search') }}">





<button class="btn btn-cari">

Cari

</button>



</div>


</form>









<div class="table-responsive">



<table class="table table-bordered align-middle">





<thead>


<tr>


<th>No</th>

<th>User</th>

<th>Foto</th>

<th>Nama Produk</th>

<th>Jenis Produk</th>

<th>Harga Beli</th>

<th>Harga Jual</th>

<th>Stok</th>

<th>Sisa Produk</th>

@if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')
<th>Aksi</th>
@endif


</tr>


</thead>









<tbody>



@forelse($products as $product)



<tr>




<td class="text-center">


{{ $products->firstItem() + $loop->index }}


</td>






<td>


{{ $product->user->name ?? '-' }}


</td>







<td class="text-center">



@if($product->foto)



<img src="{{ asset('storage/'.$product->foto) }}"
     width="70"
     height="70"
     style="object-fit:cover"
     class="img-thumbnail">



@else


<span class="text-muted">

Tidak ada foto

</span>



@endif



</td>








<td>


{{ $product->nama }}


</td>







<td>


{{ $product->jenisProduk->nama ?? '-' }}


</td>







<td>


Rp {{ number_format($product->harga_beli,0,',','.') }}


</td>







<td>


Rp {{ number_format($product->harga_jual,0,',','.') }}


</td>







<td class="text-center">


{{ $product->stok }}


</td>







<td class="text-center">


{{ $product->stok }}


</td>







@if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')
<td>



<div class="d-flex gap-1">





<a href="{{ route('produk.edit',$product->id) }}"
   class="btn btn-edit btn-sm">


Edit


</a>








<form action="{{ route('produk.destroy',$product->id) }}"
      method="POST"
      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">



@csrf

@method('DELETE')




<button class="btn btn-hapus btn-sm">


Hapus


</button>



</form>





</div>



</td>
@endif







</tr>







@empty




<tr>


<td colspan="10"
    class="text-center text-muted">


Data produk tidak ditemukan


</td>


</tr>





@endforelse






</tbody>






</table>




</div>









{{-- PAGINATION --}}


<div class="mt-3">


{{ $products->links() }}


</div>






</div>


</div>


@endsection