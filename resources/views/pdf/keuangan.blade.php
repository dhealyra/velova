<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Data Keuangan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #333;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo img {
            height: 60px;
        }

        .judul {
            flex-grow: 1;
            text-align: center;
        }

        .judul h3 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            color: #1a1a1a;
        }

        .judul span {
            font-size: 14px;
            color: #555;
        }

        .info {
            font-size: 11px;
            margin-bottom: 15px;
        }

        .info ul {
            margin: 5px 0 0 15px;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 10px;
            font-size: 11px;
        }

        th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #444;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 10px;
            color: #888;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="kop">
        <table style="border-collapse: collapse; border: none;">
            <tr>
                <td rowspan="2"
                    style="vertical-align: middle; padding-right: 15px; border: none; padding: 0; width: 60px;">
                    <div class="logo">
                        <img src="{{ public_path('/logo/logos.png') }}" alt="Logo">
                    </div>
                </td>
                <td style="border: none; padding: 0; text-align: center;">
                    <h3 style="margin: 0;">VELOVA - Aplikasi Parkir</h3>
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 0; text-align: center;">
                    <span>Laporan Keuangan</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="info">
        <div>Nomor Laporan: <strong>{{ 'LAP-KEUANGAN-' . now()->format('YmdHis') }}</strong></div>
        <div>Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>

        @if (request()->filled(['search', 'jenis_kendaraan', 'status_kondisi', 'tanggal_awal', 'tanggal_akhir']))
            <div style="margin-top: 8px;"><strong>Filter yang digunakan:</strong></div>
            <ul>
                @if (request('search'))
                    <li>Pencarian: {{ request('search') }}</li>
                @endif
                @if (request('jenis_kendaraan'))
                    <li>Jenis Kendaraan: {{ ucfirst(request('jenis_kendaraan')) }}</li>
                @endif
                @if (request('status_kondisi'))
                    <li>Status Kondisi: {{ ucfirst(request('status_kondisi')) }}</li>
                @endif
                @if (request('tanggal_awal') && request('tanggal_akhir'))
                    <li>Tanggal: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->isoFormat('D MMM Y') }}
                        - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->isoFormat('D MMM Y') }}</li>
                @endif
            </ul>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Polisi</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Status</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Total Keuangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($result as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->pembayaran->kendaraanMasuk->kendaraan->no_polisi ?? '-' }}</td>
                    <td>{{ $item->pembayaran->kendaraanMasuk->waktu_masuk ? \Carbon\Carbon::parse($item->pembayaran->kendaraanMasuk->waktu_masuk)->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $item->pembayaran->kendaraanKeluar->waktu_keluar ? \Carbon\Carbon::parse($item->pembayaran->kendaraanKeluar->waktu_keluar)->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $item->jumlah == 0 ? 'Kompensasi' : ucfirst($item->tipe) }}</td>
                    <td>{{ ucfirst($item->tipe) }}</td>
                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_keuangan ?? $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data keuangan tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        VELOVA &copy; {{ date('Y') }} - Sistem Parkir Cerdas
    </div>

</body>

</html>
