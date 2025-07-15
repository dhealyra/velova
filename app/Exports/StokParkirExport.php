<?php

namespace App\Exports;

use App\Models\StokParkir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class StokParkirExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithEvents
{
    protected $no = 1;

    public function collection()
    {
        return StokParkir::orderBy('status_pemilik')->orderBy('jenis_kendaraan')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Status Pemilik',
            'Jenis Kendaraan',
            'Kapasitas',
            'Sisa Slot',
        ];
    }

    public function map($stok): array
    {
        return [
            $this->no++,
            ucfirst($stok->status_pemilik),
            ucfirst($stok->jenis_kendaraan),
            $stok->kapasitas,
            $stok->sisa_slot,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
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
                            'color' => ['argb' => 'FF999999'],
                        ],
                    ],
                ]);

                // Header warna & center
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEFEFEF'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // Kolom No rata tengah
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );
            },
        ];
    }
}
