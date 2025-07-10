@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pembayaran Parkir</h5>
            <small class="text-body float-end">Silakan pilih metode pembayaran</small>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.simpan') }}" method="POST">
                @csrf

                {{-- Hidden Data --}}
                <input type="hidden" name="id_kendaraan_masuk" value="{{ $masuk->id }}">
                <input type="hidden" name="id_kendaraan_keluar" value="{{ $keluar->id }}">
                <input type="hidden" name="tarif" value="{{ $tarif }}">
                <input type="hidden" name="denda" value="{{ $denda }}">
                <input type="hidden" name="total" value="{{ $total }}">

                {{-- Info Kendaraan --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" class="form-control" value="{{ $masuk->kendaraan->no_polisi }}" disabled>
                </div>

                {{-- Info Waktu --}}
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Waktu Masuk</label>
                        <input type="text" class="form-control" value="{{ $masuk->waktu_masuk }}" disabled>
                    </div>
                    <div class="col">
                        <label class="form-label">Waktu Keluar</label>
                        <input type="text" class="form-control" value="{{ $keluar->waktu_keluar }}" disabled>
                    </div>
                </div>

                {{-- Info Tarif --}}
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tarif Parkir</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($tarif, 0, ',', '.') }}" disabled>
                    </div>
                    <div class="col">
                        <label class="form-label">Denda</label>
                        <input type="text" class="form-control" value="Rp {{ number_format($denda, 0, ',', '.') }}" disabled>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Total Bayar</label>
                    <input type="text" class="form-control fw-bold fs-5"
                        value="Rp {{ number_format($total, 0, ',', '.') }}" disabled>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="mb-4">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="pembayaran" class="form-select @error('pembayaran') is-invalid @enderror" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="tunai">Tunai</option>
                        <option value="gratis">Gratis</option>
                        <option value="qrish">QRIS</option>
                    </select>
                    @error('pembayaran')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
@endsection
