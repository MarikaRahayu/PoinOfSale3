<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamp('tanggal_transaksi')
                ->nullable();

            $table->integer('total_pembayaran')
                ->default(0);

            $table->string('metode_pembayaran')
                ->default('CASH');

            $table->enum('status', [
                'OPEN',
                'SELESAI',
                'CANCEL'
            ])->default('OPEN');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};