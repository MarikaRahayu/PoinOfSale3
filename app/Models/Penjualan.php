<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'metode_pembayaran',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class);
    }
}