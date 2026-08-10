@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')

<style>

body {
    background:#fff0f6;
}


/* Card */
.edit-sale-card {

    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(214,51,132,0.15);

}


/* Judul */
.edit-title {

    color:#d63384;
    font-weight:bold;
    margin-bottom:25px;

}



/* Item produk */
.item-card {

    background:#fff5fa;
    border:2px solid #ffc1dc !important;
    border-radius:15px;

}



/* Label */
.form-label {

    color:#8b1e52;
    font-weight:600;

}



/* Input */
.form-control {

    border:2px solid #ffc1dc;
    border-radius:12px;

}


.form-control:focus {

    border-color:#ff69b4;
    box-shadow:0 0 8px rgba(255,105,180,.4);

}



/* Produk disabled */
input:disabled {

    background:#ffe5f0;
    color:#8b1e52;
    font-weight:bold;

}



/* Tombol update */
.btn-update {

    background:#ff69b4;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 30px;
    font-weight:bold;

}


.btn-update:hover {

    background:#d63384;
    color:white;

}



/* Tombol kembali */
.btn-back {

    background:#f8d7e5;
    color:#8b1e52;
    border:none;
    border-radius:12px;
    padding:10px 25px;

}


.btn-back:hover {

    background:#ffb6c1;
    color:white;

}



/* Animasi */
.edit-sale-card {

    animation: muncul .5s ease;

}


@keyframes muncul {

    from {

        opacity:0;
        transform:translateY(20px);

    }


    to {

        opacity:1;
        transform:translateY(0);

    }

}


</style>





<div class="container mt-5">


    <div class="edit-sale-card">



        <h3 class="edit-title">
            Edit Penjualan
        </h3>





        <form action="{{ route('penjualan.update', $penjualan->id) }}"
              method="POST">


            @csrf
            @method('PUT')






            {{-- LIST ITEM --}}

            @foreach ($penjualan->itemPenjualan as $item)


                <div class="item-card p-3 mb-3">



                    <div class="mb-3">

                        <label class="form-label">
                            Produk
                        </label>


                        <input type="text"
                               class="form-control"
                               value="{{ $item->produk->nama }}"
                               disabled>

                    </div>






                    <div class="mb-2">

                        <label class="form-label">
                            Jumlah Produk (Qty)
                        </label>


                        <input type="number"
                               name="qty[{{ $item->id }}]"
                               class="form-control"
                               value="{{ $item->qty }}">

                    </div>




                </div>



            @endforeach







            <div class="d-flex gap-2 mt-4">


                <button type="submit"
                        class="btn btn-update">

                     Update

                </button>



                <a href="{{ route('penjualan.index') }}"
                   class="btn btn-back">

                    ← Kembali

                </a>



            </div>





        </form>




    </div>



</div>


@endsection