<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKendaraan extends Model
{
    public $fillable = ['no_polisi', 'jenis_kendaraan', 'nama_pemilik', 'status_pemilik'];

    public function kendaraanmasuk()
    {
        return $this->hasMany(KendaraanMasuk::class);
    }
}
