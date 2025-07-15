<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangans';

    protected $fillable = [
        'tipe',
        'sumber',
        'deskripsi',
        'jumlah',
        'tanggal',
        'total_keuangan',
        'user_id',
        'id_pembayaran',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran');
    }
}
