<?php

namespace Database\Seeders;

use App\Models\JenisProduk;
use Illuminate\Database\Seeder;

class JenisProdukSeeder extends Seeder
{
    public function run(): void
    {
        $jenisProduk = [
            'Makanan',
            'Minuman',
            'Snack',
            'Sembako',
            'Lainnya',
        ];

        foreach ($jenisProduk as $nama) {
            JenisProduk::create([
                'nama' => $nama,
            ]);
        }
    }
}