@extends('layouts.admin')

@section('styles')
<style>
  .wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 70px 0;
    min-height: auto;
  }

  .card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 1000px;
  }
</style>
@endsection

@section('content')
<div class="wrapper">
  <div class="col-md-5 col-lg-4">
    <div class="card text-center">
      <div class="card-header">VELOVA</div>

      <div class="card-body">
        <h5 class="card-title">Detail Pembayaran</h5>

        @if(isset($data))
        <p class="card-text">
          No Polisi: <strong>
            @if($data->kendaraanMasuk && $data->kendaraanMasuk->kendaraan)
              {{ $data->kendaraanMasuk->kendaraan->no_polisi }}
            @else
              <em>Data kendaraan tidak ditemukan</em>
            @endif
          </strong><br>

          Masuk: <strong>{{ \Carbon\Carbon::parse($data->kendaraanMasuk->waktu_masuk)->format('d-m-Y H:i') }}</strong><br>
          Keluar: <strong>{{ \Carbon\Carbon::parse($data->kendaraanKeluar->waktu_keluar)->format('d-m-Y H:i') }}</strong><br><br>

          Tarif Parkir: <strong>Rp {{ number_format($data->tarif, 0, ',', '.') }}</strong><br>
          Denda: <strong>Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}</strong><br>

          @if($data->kompensasi && $data->kompensasi > 0)
            Kompensasi: <strong class="text-danger">- Rp {{ number_format($data->kompensasi, 0, ',', '.') }}</strong><br>
          @endif

          <hr>
          Total Bayar: <strong class="text-success">Rp {{ number_format($data->total, 0, ',', '.') }}</strong><br><br>

          Metode: <strong>{{ ucfirst($data->pembayaran) }}</strong>
        </p>

        <div class="mt-3">
          <a href="{{ route('kendaraanKeluar.index') }}" class="btn btn-secondary">Kembali</a>
          <a href="{{ route('transaksi.struk.pdf', $data->id) }}" target="_blank" class="btn btn-sm btn-primary">Cetak Struk</a>
        </div>
        @else
          <div class="alert alert-danger">Data transaksi tidak tersedia.</div>
        @endif

      </div>

      <div class="card-footer text-body-secondary">
        {{ now()->format('d M Y H:i') }}
      </div>
    </div>
  </div>
</div>
@endsection
