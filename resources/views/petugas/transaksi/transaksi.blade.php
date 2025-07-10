@extends('layouts.admin')

@section('content')
<div class="col-md-6 col-lg-5">
  <div class="card text-center">
    <div class="card-header">VELOVA</div>

    <div class="card-body">
      <h5 class="card-title">Detail Pembayaran</h5>

      <p class="card-text">
        No Polisi: <strong>
                        @if($data->kendaraanMasuk && $data->kendaraanMasuk->kendaraan)
                            {{ $data->kendaraanMasuk->kendaraan->no_polisi }}
                        @else
                            <em>Data kendaraan tidak ditemukan</em>
                        @endif

                    </strong><br>
        {{-- Jenis: <strong>{{ ucfirst($data->kendaraanMasuk->kendaraan->jenis_kendaraan) }}</strong><br> --}}
        Masuk: <strong>{{ \Carbon\Carbon::parse($data->kendaraanMasuk->waktu_masuk)->format('d-m-Y H:i') }}</strong><br>
        Keluar: <strong>{{ \Carbon\Carbon::parse($data->kendaraanKeluar->waktu_keluar)->format('d-m-Y H:i') }}</strong><br><br>

        Tarif Parkir: <strong>Rp {{ number_format($data->tarif, 0, ',', '.') }}</strong><br>
        Denda: <strong>Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}</strong><br>
        <hr>
        Total Bayar: <strong class="text-success">Rp {{ number_format($data->total, 0, ',', '.') }}</strong><br><br>

        Metode: <strong>{{ ucfirst($data->pembayaran) }}</strong>
      </p>

      <a href="javascript:window.print()" class="btn btn-primary">Cetak Struk</a>
    </div>

    <div class="card-footer text-body-secondary">
      {{ now()->format('d M Y H:i') }}
    </div>
  </div>
</div>
@endsection
