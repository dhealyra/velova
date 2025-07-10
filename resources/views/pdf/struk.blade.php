<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size: 12px; font-family: sans-serif; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <div class="center">
        <h4>Struk Parkir</h4>
        <p>No Polisi: <strong>{{ $data->kendaraanMasuk->kendaraan->no_polisi }}</strong></p>
        <p>Masuk: {{ \Carbon\Carbon::parse($data->kendaraanMasuk->waktu_masuk)->format('d-m-Y H:i') }}</p>
        <p>Keluar: {{ \Carbon\Carbon::parse($data->kendaraanKeluar->waktu_keluar)->format('d-m-Y H:i') }}</p>
        <hr>
        <p>Tarif: Rp{{ number_format($data->tarif, 0, ',', '.') }}</p>
        <p>Denda: Rp{{ number_format($data->denda, 0, ',', '.') }}</p>
        <p><strong>Total: Rp{{ number_format($data->total, 0, ',', '.') }}</strong></p>
        <p>Bayar via: {{ strtoupper($data->pembayaran) }}</p>
        <hr>
        <p>Terima kasih 🙏</p>
    </div>
</body>
</html>
