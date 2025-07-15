<?php

namespace App\Http\Controllers;

use App\Exports\KendaraanExport;
use App\Exports\KendaraanKeluarExport;
use App\Exports\KendaraanMasukExport;
use App\Exports\KeuanganExport;
use App\Exports\StokParkirExport;
use App\Models\DataKendaraan;
use App\Models\KendaraanKeluar;
use App\Models\KendaraanMasuk;
use App\Models\Keuangan;
use App\Models\Kompensasi;
use App\Models\Pembayaran;
use App\Models\StokParkir;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $pdf->setPaper([0, 0, 164.4, 300], 'portrait');

        return $pdf->stream('struk-pembayaran.pdf');
    }

    public function exportKendaraanPdf(Request $request)
    {
        $query = DataKendaraan::query();

        if ($request->filled('status_pemilik')) {
            $query->where('status_pemilik', $request->status_pemilik);
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->where('jenis_kendaraan', $request->jenis_kendaraan);
        }

        $kendaraans = $query->get();

        $pdf = Pdf::loadView('pdf.kendaraan', [
            'kendaraans' => $kendaraans,
            'tanggal' => now()->translatedFormat('d F Y'),
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_kendaraan.pdf');
    }

    public function exportKendaraanExcel(Request $request)
    {
        $filters = $request->only([
            'search', 'status_pemilik', 'jenis_kendaraan', 'tanggal_awal', 'tanggal_akhir'
        ]);

        $filename = 'laporan_kendaraan_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new KendaraanExport($filters), $filename);
    }

    public function stokParkirPdf(Request $request)
    {
        $stokParkir = StokParkir::orderBy('status_pemilik')->orderBy('jenis_kendaraan')->get();

        $pdf = Pdf::loadView('pdf.stokparkir', compact('stokParkir'))->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-stok-parkir.pdf');
    }

    public function stokParkirExcel()
    {
        return Excel::download(new StokParkirExport, 'laporan-stok-parkir.xlsx');
    }

    public function exportKendaraanMasukPdf(Request $request)
    {
        $data = KendaraanMasuk::query();

        if ($request->filled('search')) {
            $data->where(function ($q) use ($request) {
                $q->where('no_polisi', 'like', "%{$request->search}%")
                ->orWhere('nama_pemilik', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status_parkir')) {
            $data->where('status_parkir', $request->status_parkir);
        }

        if ($request->filled('jenis_kendaraan')) {
            $data->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $data->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $result = $data->latest()->get();

        $pdf = Pdf::loadView('pdf.kendaraanmasuk', ['data' => $result]);
        return $pdf->stream('laporan_kendaraan_masuk.pdf');
    }

    public function exportKendaraanMasukExcel(Request $request)
    {
        $filter = [];

        // Ambil keyword pencarian
        if ($request->filled('search')) {
            $filter['search'] = $request->search;
        }

        // Filter status parkir
        if ($request->filled('status_parkir')) {
            $filter['status_parkir'] = $request->status_parkir;
        }

        // Filter jenis kendaraan
        if ($request->filled('jenis_kendaraan')) {
            $filter['jenis_kendaraan'] = $request->jenis_kendaraan;
        }

        // Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $filter['tanggal_awal'] = $request->tanggal_awal;
            $filter['tanggal_akhir'] = $request->tanggal_akhir;
        }

        return Excel::download(new KendaraanMasukExport($filter), 'laporan_kendaraan_masuk.xlsx');
    }

    public function exportKendaraanKeluarPDF(Request $request)
    {
        $query = KendaraanKeluar::with('kendaraanMasuk.kendaraan');

        if ($request->filled('search')) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('no_polisi', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_kendaraan')) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        if ($request->filled('status_kondisi')) {
            $query->where('status_kondisi', $request->status_kondisi);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('waktu_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $data = $query->latest()->get();

        $pdf = PDF::loadView('pdf.kendaraankeluar', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-kendaraan-keluar.pdf');
    }

    public function exportKendaraanKeluarExcel(Request $request)
    {
        return Excel::download(new KendaraanKeluarExport($request->all()), 'laporan-kendaraan-keluar.xlsx');
    }

    public function exportKeuanganPDF(Request $request)
    {
        $data = Keuangan::with('pembayaran.kendaraanMasuk.kendaraan', 'pembayaran.kendaraanKeluar')
            ->whereHas('pembayaran', function ($query) use ($request) {
                if ($request->filled('search')) {
                    $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                        $q->where('no_polisi', 'like', '%' . $request->search . '%')
                        ->orWhere('nama_pemilik', 'like', '%' . $request->search . '%');
                    });
                }

                if ($request->filled('jenis_kendaraan')) {
                    $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($request) {
                        $q->where('jenis_kendaraan', $request->jenis_kendaraan);
                    });
                }

                if ($request->filled('status_kondisi')) {
                    $query->whereHas('kendaraanKeluar', function ($q) use ($request) {
                        $q->where('status_kondisi', $request->status_kondisi);
                    });
                }
            });

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $data->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $result = $data->latest()->get();

        $pdf = Pdf::loadView('pdf.keuangan', compact('result'))->setPaper('A4', 'landscape');
        return $pdf->stream('laporan-keuangan.pdf');
    }

    public function exportKeuanganExcel(Request $request)
    {
        $filter = $request->all();
        return Excel::download(new KeuanganExport($filter), 'laporan-keuangan.xlsx');
    }

    public function exportKompensasiPDF(Request $request)
{
    $query = Kompensasi::with('kendaraanKeluar.kendaraanMasuk.kendaraan')
        ->latest();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('kendaraanKeluar.kendaraanMasuk.kendaraan', function ($q) use ($search) {
            $q->where('no_polisi', 'like', "%$search%")
              ->orWhere('nama_pemilik', 'like', "%$search%");
        });
    }

    if ($request->filled('status_pengajuan')) {
        $query->where('status_pengajuan', $request->status_pengajuan);
    }

    if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
        $awal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        $query->whereBetween('created_at', [$awal, $akhir]);
    }

    $kompensasis = $query->get();

    $pdf = Pdf::loadView('cetak.kompensasi', compact('kompensasis'))->setPaper('a4', 'portrait');

    return $pdf->stream('laporan-kompensasi-'.now()->format('Ymd_His').'.pdf');
}
}
