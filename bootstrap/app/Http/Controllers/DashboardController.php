<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();


        // ==========================
        // TOTAL PENJUALAN HARI INI
        // ==========================
        $totalPenjualan = Penjualan::whereDate('created_at', $hariIni)
            ->where('status', 'COMPLETED')
            ->sum('total');


        // ==========================
        // JUMLAH TRANSAKSI HARI INI
        // ==========================
        $jumlahTransaksi = Penjualan::whereDate('created_at', $hariIni)
            ->where('status', 'COMPLETED')
            ->count();



        // ==========================
        // TOTAL PEMBAYARAN CASH
        // ==========================
        $totalCash = Penjualan::whereDate('created_at', $hariIni)
            ->where('payment_method', 'cash')
            ->where('status', 'COMPLETED')
            ->sum('total');



        // ==========================
        // TOTAL PEMBAYARAN NON CASH
        // ==========================
        $totalNonCash = Penjualan::whereDate('created_at', $hariIni)
            ->whereIn('payment_method', [
                'transfer',
                'qris'
            ])
            ->where('status', 'COMPLETED')
            ->sum('total');



        // ==========================
        // PRODUK STOK RENDAH
        // ==========================
        $stokRendah = Produk::where('stok', '<=', 5)
            ->where('stok', '>', 0)
            ->get();



        // ==========================
        // PRODUK HABIS
        // ==========================
        $stokHabis = Produk::where('stok', 0)
            ->get();



        // ==========================
        // PRODUK TERLARIS
        // ==========================
        $bestSeller = DB::table('item_penjualan')
            ->join(
                'produk',
                'produk.id',
                '=',
                'item_penjualan.produk_id'
            )
            ->select(
                'produk.nama',
                DB::raw(
                    'SUM(item_penjualan.qty) as jumlah'
                )
            )
            ->groupBy(
                'produk.nama'
            )
            ->orderByDesc(
                'jumlah'
            )
            ->limit(5)
            ->get();



        return view('dashboard', [

            'totalPenjualan' => $totalPenjualan,

            'jumlahTransaksi' => $jumlahTransaksi,

            'totalCash' => $totalCash,

            'totalNonCash' => $totalNonCash,

            'stokRendah' => $stokRendah,

            'stokHabis' => $stokHabis,

            'bestSeller' => $bestSeller

        ]);
    }
}