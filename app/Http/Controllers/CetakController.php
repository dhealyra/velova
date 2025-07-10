<?php

namespace App\Http\Controllers;

use App\Models\KendaraanMasuk;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function cetakTiket($id)
    {
        $data = KendaraanMasuk::with('kendaraan')->findOrFail($id);

        $pdf = PDF::loadview('pdf.tiket', compact('data'));
        $pdf->setPaper([0, 0, 164.4, 208], 'portrait');

        return $pdf->stream('tiket-masuk.pdf');
    }

    public function cetakStruk($id)
    {
        $data = Pembayaran::with(['kendaraanMasuk.kendaraan', 'kendaraanKeluar'])->findOrFail($id);

        $pdf = PDF::loadView('pdf.struk', compact('data'));
        $pdf->setPaper([0, 0, 164.4, 400], 'portrait');

        return $pdf->stream('struk-pembayaran.pdf');
    }

}
