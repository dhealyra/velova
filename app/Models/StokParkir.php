<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokParkir extends Model
{
    protected $fillable = ['status_pemilik', 'jenis_kendaraan', 'kapasitas', 'sisa_slot'];
}
