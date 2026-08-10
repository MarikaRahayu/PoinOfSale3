<?php

namespace Database\Seeders;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $user = User::first();

            for ($i = 1; $i <= 50; $i++) {

                $penjualan = Penjualan::create([
                    'user_id' => $user->id,
                    'total_pembayaran' => 0,
                    'metode_pembayaran' => collect(['CASH', 'TRANSFER', 'QRIS'])->random(),
                   'status' => 'SELESAI',
                ]);

                $total = 0;

                $produk = Produk::inRandomOrder()->take(rand(1, 5))->get();

                foreach ($produk as $item) {

                    $qty = rand(1, 5);
                    $subtotal = $qty * $item->harga_jual;

                    ItemPenjualan::create([
                        'penjualan_id' => $penjualan->id,
                        'produk_id' => $item->id,
                        'qty' => $qty,
                        'harga_satuan' => $item->harga_jual,
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                $penjualan->update([
                    'total_pembayaran' => $total,
                ]);
            }
        });
    }
}