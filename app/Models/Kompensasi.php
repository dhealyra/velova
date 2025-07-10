<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompensasi extends Model
{
    public $fillable = ['id_kendaraan_keluar', 'jenis_kompensasi', 'tipe_kompensasi', 'kompensasi_disetujui', 'nama_pemilik', 'keterangan', 'status_pengajuan'];

    public function kendaraanmasuk()
    {
        return $this->belongsTo(KendaraanMasuk::class, 'id_kendaraan_masuk');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
