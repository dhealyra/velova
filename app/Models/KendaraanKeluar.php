<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendaraanKeluar extends Model
{
    public $fillable = ['id_kendaraan_masuk', 'waktu_keluar', 'status_kondisi', 'sebab_denda'];

    public function kendaraanmasuk()
    {
        return $this->belongsTo(KendaraanMasuk::class, 'id_kendaraan_masuk');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
