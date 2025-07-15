<?php

namespace App\Exports;

use App\Models\DataKendaraan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class KendaraanExport implements
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
        $query = DataKendaraan::query();

        if ($search = $this->filter['search'] ?? null) {
            $query->where('no_polisi', 'like', "%$search%");
        }

        if ($status = $this->filter['status_pemilik'] ?? null) {
            $query->where('status_pemilik', $status);
        }

        if ($jenis = $this->filter['jenis_kendaraan'] ?? null) {
            $query->where('jenis_kendaraan', $jenis);
        }

        if (!empty($this->filter['tanggal_awal']) && !empty($this->filter['tanggal_akhir'])) {
            $query->whereBetween('created_at', [
                $this->filter['tanggal_awal'],
                $this->filter['tanggal_akhir']
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Polisi',
            'Jenis Kendaraan',
            'Nama Pemilik',
            'Status Pemilik',
            'Tanggal Input'
        ];
    }

    public function map($k): array
    {
        return [
            $this->no++,
            $k->no_polisi ?? '-',
            ucfirst($k->jenis_kendaraan ?? '-'),
            $k->nama_pemilik ?? '-',
            ucfirst($k->status_pemilik ?? '-'),
            Carbon::parse($k->created_at)->locale('id')->isoFormat('D MMM Y')
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
                $lastCol = $sheet->getHighestColumn(); // e.g., F

                // Border semua cell
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF888888'],
                        ],
                    ],
                ]);

                // Judul kolom (baris ke-1) kasih warna abu muda & center
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEEEEEE'], // abu-abu muda
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // Kolom "No" (kolom A) rata tengah
                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );
            },
        ];
    }
}
