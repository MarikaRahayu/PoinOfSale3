@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

<style>
body{
    background:#fff0f6;
}

.sale-card{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(214,51,132,.15);
}

.sale-title{
    color:#d63384;
    font-weight:bold;
}

.total-box{
    background:#fff0f6;
    border:2px solid #ffc1dc;
    padding:15px 20px;
    border-radius:15px;
    color:#d63384;
    font-weight:bold;
}

.btn-create{
    background:#ff69b4;
    border:none;
    color:white;
    border-radius:10px;
}

.btn-create:hover{
    background:#d63384;
    color:white;
}

.form-control{
    border:2px solid #ffc1dc;
    border-radius:12px;
}

.form-control:focus{
    border-color:#ff69b4;
    box-shadow:0 0 8px rgba(255,105,180,.4);
}

.btn-search{
    background:#ffb6c1;
    border:none;
    color:#8b1e52;
}

.btn-search:hover{
    background:#ff69b4;
    color:white;
}

.table{
    border-radius:15px;
    overflow:hidden;
}

.table thead th{
    background:#d63384;
    color:white;
    text-align:center;
}

.table tbody tr:hover{
    background:#fff0f6;
}

.btn-detail{
    background:#ff69b4;
    border:none;
    color:white;
    border-radius:8px;
}

.btn-detail:hover{
    background:#d63384;
    color:white;
}

.status{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.completed{
    background:#ffc1dc;
    color:#8b1e52;
}

.open{
    background:#ffe5f0;
    color:#d63384;
}

.produk-thumb{
    width:40px;
    height:40px;
    object-fit:cover;
    border-radius:8px;
    border:2px solid #ffc1dc;
}

.produk-thumb-empty{
    width:40px;
    height:40px;
    background:#fff0f6;
    border:2px solid #ffc1dc;
    border-radius:8px;
    font-size:9px;
    color:#d63384;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.produk-item{
    margin-bottom:6px;
}

.produk-item:last-child{
    margin-bottom:0;
}

.produk-foto-item{
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:6px;
}

.produk-foto-item:last-child{
    margin-bottom:0;
}
</style>

<div class="container mt-5">

    <div class="sale-card">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="sale-title">
                Halaman Penjualan
            </h2>
        </div>

        <div class="total-box mb-4">
            Produk yang sudah terjual :
            {{ $sales->total() }} produk
        </div>

        <a href="{{ route('penjualan.create') }}" class="btn btn-create mb-4">
            + Ingin Membeli Produk
        </a>

        <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari penjualan..."
                    value="{{ request('search') }}">

                <button class="btn btn-search">
                    🔍 Search
                </button>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kasir</th>
                        <th>Produk</th>
                        <th>Nama Produk</th>
                        <th>Jenis Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Total Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($sales as $penjualan)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            @if($penjualan->tanggal_transaksi)
                                {{ \Carbon\Carbon::parse($penjualan->tanggal_transaksi)->format('d-m-Y H:i:s') }}
                            @else
                                {{ optional($penjualan->created_at)->format('d-m-Y H:i:s') }}
                            @endif
                        </td>

                        <td>
                            {{ $penjualan->user->name ?? '-' }}
                        </td>

                        <td>
                            @forelse($penjualan->itemPenjualan as $item)
                                <div class="produk-foto-item">
                                    @if($item->produk->foto ?? false)
                                        <img src="{{ asset('storage/'.$item->produk->foto) }}"
                                             alt="{{ $item->produk->nama }}"
                                             class="produk-thumb">
                                    @else
                                        <div class="produk-thumb-empty">
                                            No Foto
                                        </div>
                                    @endif
                                </div>
                            @empty
                                -
                            @endforelse
                        </td>

                        <td>
                            @forelse($penjualan->itemPenjualan as $item)
                                <div class="produk-item">
                                    {{ $item->produk->nama ?? '-' }}
                                </div>
                            @empty
                                -
                            @endforelse
                        </td>

                        <td>
                            @forelse($penjualan->itemPenjualan as $item)
                                {{ $item->produk->jenisProduk->nama ?? '-' }}
                                @if(!$loop->last)
                                    <br>
                                @endif
                            @empty
                                -
                            @endforelse
                        </td>

                        <td class="text-center">
                            {{ $penjualan->itemPenjualan->sum('qty') }}
                        </td>

                        <td>
                            Rp {{ number_format($penjualan->total_pembayaran,0,',','.') }}
                        </td>

                        <td>
                            {{ $penjualan->metode_pembayaran }}
                        </td>

                        <td class="text-center">

                            @if($penjualan->status=='SELESAI')

                                <span class="status completed">
                                    Selesai
                                </span>

                            @elseif($penjualan->status=='OPEN')

                                <span class="status open">
                                    Open
                                </span>

                            @else

                                <span class="status open">
                                    {{ $penjualan->status }}
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <a href="{{ route('penjualan.show',$penjualan->id) }}"
                               class="btn btn-detail btn-sm mb-1">
                                Detail
                            </a>

                            @if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')
                            <form action="{{ route('penjualan.destroy',$penjualan->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus penjualan ini?')">

                                    Hapus

                                </button>

                            </form>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="11" class="text-center text-muted">
                            Data penjualan kosong
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $sales->links() }}
        </div>

    </div>

</div>

@endsection