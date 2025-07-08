<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    public $fillable = ['jumlah', 'id_pembayaran', 'waktu_transaksi'];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
