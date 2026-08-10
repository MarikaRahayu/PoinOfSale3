<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Produk;
use App\Models\ItemPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * List produk
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->search;

        $products = Produk::with('user')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10);

        return view('produk.index', compact('products'));
    }

    /**
     * Form create
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }

    /**
     * Simpan produk
     */
    public function store(Request $request)
    {
        $this->authorize('create', Produk::class);

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_produk' => 'required|string|max:100',
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('products', 'public');
        }

        Produk::create([
            'user_id'      => Auth::id(),
            'foto'         => $foto,
            'jenis_produk' => $request->jenis_produk,
            'nama'         => $request->nama,
            'harga_beli'   => $request->harga_beli,
            'harga_jual'   => $request->harga_jual,
            'stok'         => $request->stok,
        ]);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form edit
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);

        return view('produk.edit', [
            'product' => $produk,
        ]);
    }

    /**
     * Update produk
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $data = $request->validated();

        if ($request->hasFile('foto')) {

            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Hapus produk
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        ItemPenjualan::where('produk_id', $produk->id)->delete();

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}