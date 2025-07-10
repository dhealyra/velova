@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center">
        <span>Data Transaksi Pembayaran</span>
    </h5>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover" id="dataTransaksi">
            <thead>
                <tr>
                    <th>No Polisi</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Tarif</th>
                    <th>Denda</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $item)
                <tr>
                    <td>{{ $item->kendaraanMasuk->kendaraan->no_polisi ?? '-' }}</td>
                    <td>{{ $item->kendaraanMasuk->kendaraan->jenis_kendaraan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->kendaraanMasuk->waktu_masuk)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->kendaraanKeluar->waktu_keluar)->format('d/m/Y H:i') }}</td>
                    <td>Rp{{ number_format($item->tarif, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->denda, 0, ',', '.') }}</td>
                    <td><strong>Rp{{ number_format($item->total, 0, ',', '.') }}</strong></td>
                    <td>{{ ucfirst($item->pembayaran) }}</td>
                    <td>
                        <a href="{{ route('pembayaran.show', $item->id) }}" class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $transaksi->links() }}
    </div>
</div>
@endsection
