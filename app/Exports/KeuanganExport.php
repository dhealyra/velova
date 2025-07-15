<?php

namespace App\Exports;

use App\Models\Keuangan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class KeuanganExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $filter;
    protected $no = 1;

    public function __construct($filter = [])
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Keuangan::with('pembayaran.kendaraanMasuk.kendaraan', 'pembayaran.kendaraanKeluar');

        // Filter berdasarkan relasi pembayaran
        $query->whereHas('pembayaran', function ($q) {
            if ($search = $this->filter['search'] ?? null) {
                $q->whereHas('kendaraanMasuk.kendaraan', function ($qq) use ($search) {
                    $qq->where('no_polisi', 'like', "%$search%")
                        ->orWhere('nama_pemilik', 'like', "%$search%");
                });
            }

            if ($jenis = $this->filter['jenis_kendaraan'] ?? null) {
                $q->whereHas('kendaraanMasuk.kendaraan', function ($qq) use ($jenis) {
                    $qq->where('jenis_kendaraan', $jenis);
                });
            }

            if ($status = $this->filter['status_kondisi'] ?? null) {
                $q->whereHas('kendaraanKeluar', function ($qq) use ($status) {
                    $qq->where('status_kondisi', $status);
                });
            }
        });

        if (!empty($this->filter['tanggal_awal']) && !empty($this->filter['tanggal_akhir'])) {
            $query->whereBetween('tanggal', [
                $this->filter['tanggal_awal'],
                $this->filter['tanggal_akhir']
            ]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Polisi',
            'Waktu Masuk',
            'Waktu Keluar',
            'Status',
            'Tipe',
            'Jumlah',
            'Total Keuangan'
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->pembayaran->kendaraanMasuk->kendaraan->no_polisi ?? '-',
            $item->pembayaran->kendaraanMasuk->waktu_masuk ?
                Carbon::parse($item->pembayaran->kendaraanMasuk->waktu_masuk)->format('d/m/Y H:i') : '-',
            $item->pembayaran->kendaraanKeluar->waktu_keluar ?
                Carbon::parse($item->pembayaran->kendaraanKeluar->waktu_keluar)->format('d/m/Y H:i') : '-',
            $item->jumlah == 0 ? 'Kompensasi' : ucfirst($item->tipe),
            ucfirst($item->tipe),
            'Rp ' . number_format($item->jumlah, 0, ',', '.'),
            'Rp ' . number_format($item->total_keuangan ?? $item->jumlah, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // baris header bold
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                // Border semua cell
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF888888'],
                        ],
                    ],
                ]);

                // Header abu & center
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEEEEEE'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => ['bold' => true],
                ]);

                // Kolom No & Tipe di tengah
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("F2:F{$lastRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
