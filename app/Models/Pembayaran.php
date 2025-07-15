<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    public $fillable = ['id_kendaraan_masuk', 'id_kendaraan_keluar', 'id_kompensasi', 'denda', 'kompensasi', 'tarif', 'total', 'keterangan', 'pembayaran', 'user_id'];

    public function kendaraanMasuk()
    {
        return $this->belongsTo(KendaraanMasuk::class,'id_kendaraan_masuk');
    }

    public function kendaraankeluar()
    {
        return $this->belongsTo(KendaraanKeluar::class, 'id_kendaraan_keluar');
    }

    public function kompensasi()
    {
        return $this->belongsTo(Kompensasi::class, 'id_kompensasi');
    }

    public function keuangan()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
