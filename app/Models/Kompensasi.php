<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompensasi extends Model
{
    public $fillable = ['id_kendaraan_keluar', 'tipe_kerusakan', 'kompensasi_disetujui', 'nama_pemilik', 'keterangan'];

    public function kendaraanmasuk()
    {
        return $this->belongsTo(KendaraanMasuk::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
