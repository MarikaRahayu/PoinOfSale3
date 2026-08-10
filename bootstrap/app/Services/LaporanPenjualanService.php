<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanPenjualanService
{
    public function ringkasanHariIni(): array
    {
        $data = DB::table('penjualan')
            ->whereDate('tanggal_transaksi', Carbon::today())
            ->where('status', 'SELESAI')
            ->selectRaw("
                COUNT(*) as total_transaksi,
                COALESCE(SUM(total_pembayaran),0) as total_penjualan,
                COALESCE(SUM(CASE
                    WHEN metode_pembayaran = 'CASH'
                    THEN total_pembayaran
                    ELSE 0
                END),0) as total_cash,
                COALESCE(SUM(CASE
                    WHEN metode_pembayaran <> 'CASH'
                    THEN total_pembayaran
                    ELSE 0
                END),0) as total_non_tunai
            ")
            ->first();

        return [
            'total_transaksi' => $data->total_transaksi,
            'total_penjualan' => $data->total_penjualan,
            'total_cash' => $data->total_cash,
            'total_non_tunai' => $data->total_non_tunai,
        ];
    }

    public function produkTerlarisHariIni(int $limit = 5)
    {
        return DB::table('item_penjualan')
            ->join('penjualan', 'penjualan.id', '=', 'item_penjualan.penjualan_id')
            ->join('produk', 'produk.id', '=', 'item_penjualan.produk_id')
            ->where('penjualan.status', 'SELESAI')
            ->whereDate('penjualan.tanggal_transaksi', Carbon::today())
            ->groupBy(
                'produk.id',
                'produk.nama',
                'produk.stok'
            )
            ->select(
                'produk.nama',
                'produk.stok',
                DB::raw('SUM(item_penjualan.qty) as total_terjual')
            )
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}