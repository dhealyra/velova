<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Laporan Stok Parkir</title>
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 6px 10px;
      font-size: 11px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
      font-weight: 600;
    }

    .footer {
      text-align: right;
      margin-top: 20px;
      font-size: 10px;
      color: #888;
    }
  </style>
</head>
<body>

  <div class="kop">
    <table style="border-collapse: collapse; border: none;">
        <tr>
        <td rowspan="2" style="vertical-align: middle; padding-right: 15px; border: none; padding: 0; width: 60px; vertical-align: middle;">
            <div class="logo">
            <img src="{{ public_path('/logo/logos.png') }}" alt="Logo">
            </div>
        </td>
        <td style="border: none; padding: 0; text-align: center; vertical-align: middle">
            <h3 style="margin: 0; font-size: 18px; text-transform: uppercase; color: #1a1a1a;">VELOVA - Aplikasi Parkir</h3>
        </td>
        </tr>
        <tr>
        <td style="border: none; padding: 0; text-align: center; vertical-align: middle">
            <span style="font-size: 14px; color: #555;">Laporan Stok Parkir</span>
        </td>
        </tr>
    </table>
  </div>

  <div class="info">
    <div>Nomor Laporan: <strong>{{ 'STOK-' . now()->format('YmdHis') }}</strong></div>
    <div>Tanggal Cetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Status Pemilik</th>
        <th>Jenis Kendaraan</th>
        <th>Kapasitas</th>
        <th>Sisa Slot</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($stokParkir as $index => $stok)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ ucfirst($stok->status_pemilik) }}</td>
          <td>{{ ucfirst($stok->jenis_kendaraan) }}</td>
          <td>{{ $stok->kapasitas }}</td>
          <td>{{ $stok->sisa_slot }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5">Data tidak ditemukan</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="footer">
    VELOVA &copy; {{ date('Y') }} - Sistem Parkir Cerdas
  </div>

</body>
</html>
