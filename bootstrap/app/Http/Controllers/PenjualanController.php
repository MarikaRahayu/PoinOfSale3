<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\ItemPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $sales = Penjualan::with('user')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('metode_pembayaran', 'like', "%{$keyword}%")
                      ->orWhere('status', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('penjualan.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $produks = Produk::when($request->search, function ($query) use ($request) {
                $query->where('nama', 'like', "%{$request->search}%");
            })
            ->where('stok', '>', 0)
            ->get();

        $keranjang = session()->get('keranjang', []);

        return view('penjualan.create', compact('produks', 'keranjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'qty' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($request->qty > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$produk->id])) {
            $keranjang[$produk->id]['qty'] += $request->qty;
        } else {
            $keranjang[$produk->id] = [
                'produk_id' => $produk->id,
                'nama' => $produk->nama,
                'harga' => $produk->harga_jual,
                'qty' => $request->qty,
            ];
        }

        $keranjang[$produk->id]['subtotal'] =
            $keranjang[$produk->id]['harga'] *
            $keranjang[$produk->id]['qty'];

        session()->put('keranjang', $keranjang);

        return redirect()
            ->route('penjualan.create')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroyItem($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
        }

        session()->put('keranjang', $keranjang);

        return redirect()
            ->route('penjualan.create')
            ->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        DB::transaction(function () use ($keranjang, $request) {

            $total = collect($keranjang)->sum('subtotal');

            $penjualan = Penjualan::create([
                'user_id' => Auth::id(),
                'tanggal_transaksi' => now(),
                'total_pembayaran' => $total,
                'metode_pembayaran' => strtoupper($request->payment_method),
                'status' => 'SELESAI',
            ]);

            foreach ($keranjang as $item) {

                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                Produk::where('id', $item['produk_id'])
                    ->decrement('stok', $item['qty']);
            }
        });

        session()->forget('keranjang');

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load([
            'user',
            'itemPenjualan.produk'
        ]);

        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'metode_pembayaran' => 'required',
            'status' => 'required',
            'total_pembayaran' => 'required|numeric',
        ]);

        $penjualan->update([
            'metode_pembayaran' => strtoupper($request->metode_pembayaran),
            'status' => strtoupper($request->status),
            'total_pembayaran' => $request->total_pembayaran,
        ]);

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Penjualan berhasil dihapus.');
    }

    public function cancel()
    {
        session()->forget('keranjang');

        return redirect()
            ->route('penjualan.create')
            ->with('success', 'Transaksi dibatalkan.');
    }
}