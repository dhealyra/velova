<?php

namespace App\Exports;

use App\Models\KendaraanKeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class KendaraanKeluarExport implements
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
        $query = KendaraanKeluar::with('kendaraanMasuk.kendaraan');

        if ($search = $this->filter['search'] ?? null) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($search) {
                $q->where('no_polisi', 'like', "%$search%")
                  ->orWhere('nama_pemilik', 'like', "%$search%");
            });
        }

        if ($jenis = $this->filter['jenis_kendaraan'] ?? null) {
            $query->whereHas('kendaraanMasuk.kendaraan', function ($q) use ($jenis) {
                $q->where('jenis_kendaraan', $jenis);
            });
        }

        if ($status = $this->filter['status_kondisi'] ?? null) {
            $query->where('status_kondisi', $status);
        }

        if (!empty($this->filter['tanggal_awal']) && !empty($this->filter['tanggal_akhir'])) {
            $query->whereBetween('waktu_keluar', [
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
            'Waktu Keluar',
            'Status Kondisi',
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->kendaraanMasuk->kendaraan->no_polisi ?? '-',
            ucfirst($item->kendaraanMasuk->kendaraan->jenis_kendaraan ?? '-'),
            $item->kendaraanMasuk->kendaraan->nama_pemilik ?? '-',
            Carbon::parse($item->waktu_keluar)->locale('id')->isoFormat('D MMM Y HH:mm'),
            ucfirst($item->status_kondisi ?? '-'),
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

                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF888888'],
                        ],
                    ],
                ]);

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

                $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );
            },
        ];
    }
}
