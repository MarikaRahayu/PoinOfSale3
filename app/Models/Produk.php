<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'foto',
        'jenis_produk_id',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenisProduk()
    {
        return $this->belongsTo(
            JenisProduk::class,
            'jenis_produk_id'
        );
    }

    public function itemPenjualan()
    {
        return $this->hasMany(
            ItemPenjualan::class,
            'produk_id'
        );
    }
}