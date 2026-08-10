<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\ItemPenjualan;
use App\Models\Produk;
use App\Models\Penjualan;


class ItemPenjualanController extends Controller
{


    public function index(Request $request)
    {

        $query = Penjualan::with('user');


        if($request->search){

            $query->whereHas('user', function($q) use($request){

                $q->where(
                    'name',
                    'like',
                    '%'.$request->search.'%'
                );

            });

        }


        if(Auth::user()->role->name != 'admin'){

            $query->where(
                'user_id',
                Auth::id()
            );

        }


        $penjualans = $query
            ->latest()
            ->paginate(10);



        return view(
            'penjualan.index',
            compact('penjualans')
        );

    }




    public function create(Request $request)
    {


        $penjualan = Penjualan::firstOrCreate(

            [
                'user_id'=>Auth::id(),
                'status'=>'OPEN'
            ],

            [
                'total_pembayaran'=>0,
                'metode_pembayaran'=>'CASH'
            ]

        );



        $produks = Produk::when(
            $request->search,

            function($q) use($request){

                $q->where(
                    'nama',
                    'like',
                    '%'.$request->search.'%'
                );

            }

        )
        ->orderBy('nama')
        ->get();



        $keranjang = ItemPenjualan::with('produk')
            ->where(
                'penjualan_id',
                $penjualan->id
            )
            ->get();



        return view(
            'penjualan.pos',
            compact(
                'penjualan',
                'produks',
                'keranjang'
            )
        );

    }







    public function store(Request $request)
    {


        $request->validate([

            'produk_id'=>'required|exists:produk,id',

            'qty'=>'required|integer|min:1'

        ]);




        $penjualan = Penjualan::where(

            'user_id',
            Auth::id()

        )
        ->where(

            'status',
            'OPEN'

        )
        ->first();



        if(!$penjualan){

            $penjualan = Penjualan::create([

                'user_id'=>Auth::id(),

                'status'=>'OPEN',

                'total_pembayaran'=>0,

                'metode_pembayaran'=>'CASH'

            ]);

        }





        $produk = Produk::findOrFail(
            $request->produk_id
        );



        $harga = $produk->harga_jual;





        $item = ItemPenjualan::where(

            'penjualan_id',
            $penjualan->id

        )
        ->where(

            'produk_id',
            $produk->id

        )
        ->first();





        if($item){


            $qtyBaru = $item->qty + $request->qty;


            $item->update([

                'qty'=>$qtyBaru,

                'harga_satuan'=>$harga,

                'subtotal'=>$qtyBaru * $harga

            ]);



        }else{


            ItemPenjualan::create([

                'penjualan_id'=>$penjualan->id,

                'produk_id'=>$produk->id,

                'qty'=>$request->qty,

                'harga_satuan'=>$harga,

                'subtotal'=>$harga * $request->qty

            ]);


        }



        // update total sementara

        $total = ItemPenjualan::where(
            'penjualan_id',
            $penjualan->id
        )
        ->sum('subtotal');


        $penjualan->update([

            'total_pembayaran'=>$total

        ]);




        return redirect()
            ->route('penjualan.create')
            ->with(
                'success',
                'Produk berhasil masuk keranjang'
            );


    }







    public function checkout(Request $request)
    {


        $request->validate([

            'payment_method'=>'required'

        ]);




        DB::transaction(function() use($request){



            $penjualan = Penjualan::where(

                'user_id',
                Auth::id()

            )
            ->where(

                'status',
                'OPEN'

            )
            ->firstOrFail();






            // hitung ulang total

            $total = ItemPenjualan::where(

                'penjualan_id',
                $penjualan->id

            )
            ->selectRaw(
                'SUM(qty * harga_satuan) as total'
            )
            ->value('total');





            if(!$total){

                abort(
                    422,
                    'Keranjang kosong'
                );

            }





            $penjualan->update([

                'status'=>'SELESAI',

                'total_pembayaran'=>$total,

                'metode_pembayaran'=>strtoupper(
                    $request->payment_method
                )

            ]);



        });





        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Checkout berhasil'
            );


    }







    public function destroy($id)
    {


        ItemPenjualan::findOrFail($id)
            ->delete();


        return redirect()
            ->route('penjualan.create')
            ->with(
                'success',
                'Produk berhasil dihapus'
            );

    }







    public function cancel()
    {


        $penjualan = Penjualan::where(

            'user_id',
            Auth::id()

        )
        ->where(

            'status',
            'OPEN'

        )
        ->first();



        if($penjualan){


            ItemPenjualan::where(
                'penjualan_id',
                $penjualan->id
            )
            ->delete();



            $penjualan->update([

                'status'=>'CANCEL',

                'total_pembayaran'=>0

            ]);

        }



        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Transaksi dibatalkan'
            );

    }


}