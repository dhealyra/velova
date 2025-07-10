@extends('layouts.admin')

@section('content')
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
      <a href="{{ route('transaksi.tiket.pdf', $data->id) }}" class="btn btn-sm btn-primary" target="_blank">
        Cetak Tiket
        </a>

    </div>

    <div class="card-footer text-body-secondary">
      {{ now()->format('d M Y H:i') }}
    </div>
  </div>
</div>
@endsection
