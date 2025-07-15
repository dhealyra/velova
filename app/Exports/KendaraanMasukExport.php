<?php

namespace App\Exports;

use App\Models\KendaraanMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class KendaraanMasukExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
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
        $query = KendaraanMasuk::with('kendaraan');

        if ($search = $this->filter['search'] ?? null) {
            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('no_polisi', 'like', "%$search%");
            });
        }

        if ($status = $this->filter['status_parkir'] ?? null) {
            $query->where('status_parkir', $status);
        }

        if ($jenis = $this->filter['jenis_kendaraan'] ?? null) {
            $query->whereHas('kendaraan', function ($q) use ($jenis) {
                $q->where('jenis_kendaraan', $jenis);
            });
        }

        if (!empty($this->filter['tanggal_awal']) && !empty($this->filter['tanggal_akhir'])) {
            $query->whereBetween('created_at', [
                $this->filter['tanggal_awal'],
                $this->filter['tanggal_akhir'],
            ]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Polisi',
            'Jenis Kendaraan',
            'Nama Pemilik',
            'Jam Masuk',
            'Status Parkir',
        ];
    }

    public function map($item): array
    {
        $noPolisi = $item->kendaraan->no_polisi ?? null;
        $namaPemilik = $item->kendaraan->nama_pemilik ?? null;

        return [
            $this->no++,
            $noPolisi ? $noPolisi : ucfirst($item->kendaraan->jenis_kendaraan ?? '-'),
            ucfirst($item->kendaraan->jenis_kendaraan ?? '-'),
            $namaPemilik ? $namaPemilik : 'Tamu',
            $item->waktu_masuk ? Carbon::parse($item->waktu_masuk)->format('H:i') : '-',
            $item->status_parkir == 1 ? 'Sudah Keluar' : 'Terparkir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header baris pertama bold
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                // 🌟 Style header (baris 1)
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEEEEEE'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // ✅ Reset style data dari baris 2 ke bawah (biar gak bold ketularan)
                $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
                    'font' => ['bold' => false],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // 🎯 Kolom "No" rata tengah dari baris 2 ke bawah
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );

                // 🔲 Border seluruh isi tabel
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF888888'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
