<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Produk;
use App\Models\JenisProduk;
use App\Models\ItemPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->search;

        $products = Produk::with([
                'user',
                'jenisProduk'
            ])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10);

        return view('produk.index', compact('products'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        // Ambil jenis produk sesuai urutan ID di database
        $jenisProduk = JenisProduk::orderBy('id', 'asc')->get();

        return view('produk.create', compact('jenisProduk'));
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        $this->authorize('create', Produk::class);

        $validated = $request->validate([
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            // ID harus berasal dari tabel jenis_produk
            'jenis_produk_id' => [
                'required',
                'integer',
                'exists:jenis_produk,id',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'harga_beli' => [
                'required',
                'numeric',
                'min:0',
            ],

            'harga_jual' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Foto
        |--------------------------------------------------------------------------
        */

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('products', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Produk
        |--------------------------------------------------------------------------
        */

        Produk::create([
            'user_id' => Auth::id(),
            'foto' => $foto,
            'jenis_produk_id' => $validated['jenis_produk_id'],
            'nama' => $validated['nama'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
            'stok' => $validated['stok'],
        ]);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form edit produk
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);

        // Ambil jenis produk sesuai urutan ID database
        $jenisProduk = JenisProduk::orderBy('id', 'asc')->get();

        return view('produk.edit', [
            'product' => $produk,
            'jenisProduk' => $jenisProduk,
        ]);
    }

    /**
     * Update produk
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Pastikan jenis_produk_id berupa integer
        |--------------------------------------------------------------------------
        */

        if (isset($data['jenis_produk_id'])) {
            $data['jenis_produk_id'] = (int) $data['jenis_produk_id'];
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Foto Baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')
                ->store('products', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Produk
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Hapus item penjualan yang menggunakan produk
        |--------------------------------------------------------------------------
        */

        ItemPenjualan::where('produk_id', $produk->id)->delete();

        /*
        |--------------------------------------------------------------------------
        | Hapus foto produk
        |--------------------------------------------------------------------------
        */

        if (
            $produk->foto &&
            Storage::disk('public')->exists($produk->foto)
        ) {
            Storage::disk('public')->delete($produk->foto);
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus produk
        |--------------------------------------------------------------------------
        */

        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}