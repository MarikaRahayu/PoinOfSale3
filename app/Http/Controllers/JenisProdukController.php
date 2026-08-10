<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use Illuminate\Http\Request;

class JenisProdukController extends Controller
{
    /**
     * Menampilkan daftar jenis produk
     */
    public function index(Request $request)
    {
        $keyword = $request->search;

        $jenisProduk = JenisProduk::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalJenis = JenisProduk::count();

        return view('jenis_produk.index', compact(
            'jenisProduk',
            'totalJenis'
        ));
    }

    /**
     * Form tambah jenis produk
     */
    public function create()
    {
        return view('jenis_produk.create');
    }

    /**
     * Simpan jenis produk
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:jenis_produk,nama',
            ],
        ], [
            'nama.required' => 'Nama jenis produk wajib diisi.',
            'nama.unique' => 'Jenis produk tersebut sudah ada.',
        ]);

        JenisProduk::create([
            'nama' => $request->nama,
        ]);

        return redirect()
            ->route('jenis-produk.index')
            ->with('success', 'Jenis produk berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit(JenisProduk $jenisProduk)
    {
        return view('jenis_produk.edit', compact('jenisProduk'));
    }

    /**
     * Update jenis produk
     */
    public function update(Request $request, JenisProduk $jenisProduk)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                'unique:jenis_produk,nama,' . $jenisProduk->id,
            ],
        ], [
            'nama.required' => 'Nama jenis produk wajib diisi.',
            'nama.unique' => 'Jenis produk tersebut sudah ada.',
        ]);

        $jenisProduk->update([
            'nama' => $request->nama,
        ]);

        return redirect()
            ->route('jenis-produk.index')
            ->with('success', 'Jenis produk berhasil diupdate.');
    }

    /**
     * Hapus jenis produk
     */
    public function destroy(JenisProduk $jenisProduk)
    {
        // Cek apakah jenis masih digunakan oleh produk
        if ($jenisProduk->produk()->exists()) {
            return redirect()
                ->route('jenis-produk.index')
                ->with('error', 'Jenis produk tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $jenisProduk->delete();

        return redirect()
            ->route('jenis-produk.index')
            ->with('success', 'Jenis produk berhasil dihapus.');
    }
}