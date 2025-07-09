<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KendaraanMasuk extends Model
{
    public $fillable = ['waktu_masuk', 'id_kendaraan', 'status_parkir'];

    public function kendaraan()
    {
        return $this->belongsTo(DataKendaraan::class, 'id_kendaraan');
    }

    public function kendaraankeluar()
    {
        return $this->hasOne(KendaraanKeluar::class);
    }

    public function kompensasi()
    {
        return $this->hasOne(Kompensasi::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
