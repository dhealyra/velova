<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompensasi extends Model
{
    public $fillable = ['id_kendaraan_keluar', 'bukti', 'jenis_kompensasi', 'tipe_kompensasi', 'kompensasi_disetujui', 'nama_pemilik', 'keterangan', 'status_pengajuan', 'user_id'];

    public function kendaraankeluar()
    {
        return $this->belongsTo(KendaraanKeluar::class, 'id_kendaraan_keluar');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deleteImage()
    {
        if ($this->image && file_exists(public_path('image/bukti'.$this->image))) {
            return unlink(public_path('image/bukti'.$this->image));
        }
    }
}
