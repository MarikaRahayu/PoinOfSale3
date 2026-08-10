<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'jenis_produk_id' => 'required|integer|exists:jenis_produk,id',

            'nama' => 'required|string|max:255',

            'harga_beli' => 'required|integer|min:0',

            'harga_jual' => 'required|integer|min:0',

            'stok' => 'required|integer|min:0',

        ];
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [

            'foto.image' => 'File yang diupload harus gambar.',

            'foto.mimes' => 'Extensi gambar harus JPG, JPEG, PNG.',

            'foto.max' => 'Maksimal ukuran gambar 2MB.',

            'jenis_produk_id.required' => 'Jenis produk wajib dipilih.',

            'jenis_produk_id.integer' => 'Jenis produk tidak valid.',

            'jenis_produk_id.exists' => 'Jenis produk tidak ditemukan.',

            'nama.required' => 'Nama wajib diisi.',

            'harga_beli.required' => 'Harga beli wajib diisi.',

            'harga_beli.integer' => 'Harga beli harus angka.',

            'harga_jual.required' => 'Harga jual wajib diisi.',

            'harga_jual.integer' => 'Harga jual harus angka.',

            'stok.required' => 'Stok wajib diisi.',

            'stok.integer' => 'Stok harus angka.',

        ];
    }
}