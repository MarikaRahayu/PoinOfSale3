<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_penjualan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('penjualan_id')
                ->constrained('penjualan')
                ->cascadeOnDelete();

            $table->foreignId('produk_id')
                ->constrained('produk')
                ->restrictOnDelete();

            // sesuai controller:
            // 'qty' => $request->qty
            $table->integer('qty');

            // sesuai controller:
            // 'harga_satuan' => $harga
            $table->integer('harga_satuan');

            // sesuai controller:
            // 'subtotal' => $harga * $request->qty
            $table->integer('subtotal')
                ->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_penjualan');
    }
};