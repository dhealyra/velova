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
      font-family: 'Courier New', monospace; /* gaya tiket */
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
  </style>

</head>
<body>
    <div class="title">
        <div class="tiket">TIKET MASUK</div>
        <div class="velova">Velova</div>
    </div>

  <div class="row">
    <div class="label">No Polisi</div>
    <div class="value">{{ $data->kendaraan->no_polisi }}</div>
  </div>

  <div class="row">
    <div class="label">Jenis Kendaraan</div>
    <div class="value">{{ ucfirst($data->kendaraan->jenis_kendaraan) }}</div>
  </div>

  <div class="row">
    <div class="label">Waktu Masuk</div>
    <div class="value" style="font-size: 10px;">
      {{ \Carbon\Carbon::parse($data->waktu_masuk)->format('d M Y H:i') }}
    </div>
  </div>

  <div class="noted">
    Harap simpan tiket ini dengan baik. Tiket ini wajib ditunjukkan saat keluar parkiran.
  </div>
</body>
</html>
