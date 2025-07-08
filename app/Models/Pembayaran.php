<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public $fillable = ['id_kendaraan_masuk', 'id_kendaraan_keluar', 'id_kompensasi', 'total', 'pembayaran'];

    public function kendaraanmasuk()
    {
        return $this->belongsTo(KendaraanMasuk::class);
    }

    public function kendaraankeluar()
    {
        return $this->belongsTo(KendaraanKeluar::class);
    }

    public function kompensasi()
    {
        return $this->belongsTo(Kompensasi::class);
    }

    public function keuangan()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
