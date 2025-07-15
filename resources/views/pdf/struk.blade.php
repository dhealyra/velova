<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

    body {
      font-family: 'Helvetica', sans-serif;
      font-size: 10px;
      color: #000;
    }

    .title {
      text-align: center;
      margin-bottom: 12px;
    }

    .title .tiket {
      font-family: 'Courier New', monospace;
      font-size: 14px;
      font-weight: bold;
      letter-spacing: 2px;
      color: #84838a;
    }

    .title .velova {
      font-family: 'Courier New', monospace;
      font-size: 16px;
      font-weight: bold;
      color: #080808;
    }

    .label {
      color: #6E6B7B;
      font-size: 9px;
    }

    .value {
      font-weight: bold;
      font-size: 12px;
    }

    .row {
      margin-bottom: 6px;
    }

    .noted {
      margin-top: 12px;
      padding: 5px;
      background-color: #F4F3FF;
      border-left: 4px solid #919193;
      font-size: 8px;
      color: #84838;
    }

    .hr {
      border: 0;
      border-top: 1px dashed #999;
      margin: 10px 0;
    }
  </style>
</head>
<body>

  <div class="title">
    <div class="tiket">STRUK PARKIR</div>
    <div class="velova">Velova</div>
  </div>

  <div class="row">
    <div class="label">No Polisi</div>
    <div class="value">{{ $data->kendaraanMasuk->kendaraan->no_polisi }}</div>
  </div>

  <div class="row">
    <div class="label">Jenis Kendaraan</div>
    <div class="value">{{ ucfirst($data->kendaraanMasuk->kendaraan->jenis_kendaraan) }}</div>
  </div>

  <div class="row">
    <div class="label">Waktu Masuk</div>
    <div class="value">{{ \Carbon\Carbon::parse($data->kendaraanMasuk->waktu_masuk)->format('d M Y H:i') }}</div>
  </div>

  <div class="row">
    <div class="label">Waktu Keluar</div>
    <div class="value">{{ \Carbon\Carbon::parse($data->kendaraanKeluar->waktu_keluar)->format('d M Y H:i') }}</div>
  </div>

  <hr class="hr">

  <div class="row">
    <div class="label">Tarif Parkir</div>
    <div class="value">Rp{{ number_format($data->tarif, 0, ',', '.') }}</div>
  </div>

  <div class="row">
    <div class="label">Denda</div>
    <div class="value">Rp{{ number_format($data->denda ?? 0, 0, ',', '.') }}</div>
  </div>

  @if($data->kompensasi && $data->kompensasi > 0)
  <div class="row">
    <div class="label">Kompensasi</div>
    <div class="value">- Rp{{ number_format($data->kompensasi, 0, ',', '.') }}</div>
  </div>
  @endif

  <hr class="hr">

  <div class="row">
    <div class="label">Total Bayar</div>
    <div class="value text-success">Rp{{ number_format($data->total, 0, ',', '.') }}</div>
  </div>

  <div class="row">
    <div class="label">Metode</div>
    <div class="value">{{ strtoupper($data->pembayaran) }}</div>
  </div>

  <div class="noted">
    Simpan struk ini sebagai bukti pembayaran parkir. Terima kasih telah menggunakan layanan kami 🙏
  </div>

</body>
</html>
