@extends('layouts.admin')

@section('styles')
<style>
  .wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 100px 0;
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
<div class="col-md-6 col-lg-4">
  <div class="card text-center">
    <div class="card-header">VELOVA</div>

    <div class="card-body">
      <h5 class="card-title">Tiket Parkir</h5>

      <p class="card-text">
        No Polisi: <strong>{{ $data->kendaraan->no_polisi }}</strong> <br>
        Jenis: <strong>{{ ucfirst($data->kendaraan->jenis_kendaraan) }}</strong> <br>
        Masuk: <strong>{{ \Carbon\Carbon::parse($data->waktu_masuk)->format('d-m-Y H:i') }}</strong>
      </p>

      {{-- 💡 AKSI --}}
        <div class="mt-3">
            <a href="{{ route('parkir.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <a href="{{ route('transaksi.tiket.pdf', $data->id) }}" class="btn btn-sm btn-primary" target="_blank">
                Cetak Tiket
            </a>
        </div>


    </div>

    <div class="card-footer text-body-secondary">
      {{ now()->format('d M Y H:i') }}
    </div>
  </div>
</div>
</div>
@endsection
