@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Data Keuangan Parkir</span>
        <div class="d-flex gap-2">
            <a href="{{ route('keuangan.export.excel', request()->query()) }}" target="_blank" class="btn btn-sm btn-success">
                <i class="ri-file-excel-line me-1"></i> Export Excel
            </a>
            <a href="{{ route('keuangan.export.pdf', request()->query()) }}" target="_blank" class="btn btn-sm btn-danger">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </a>
        </div>
    </h5>

    {{-- Filter --}}
    <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex flex-wrap gap-2 mb-3 align-items-end px-3 pt-3">
        {{-- Search --}}
        <div class="position-relative" style="min-width: 180px;">
            <input type="text" name="search" class="form-control form-control-xs pe-5 py-1"
                placeholder="Cari No Polisi / Pemilik..." value="{{ request('search') }}" style="height: 32px;">
            <button type="submit" class="btn position-absolute top-0 end-0 mt-1 me-3 p-0 border-0 bg-transparent">
                <i class="ri-search-line text-muted"></i>
            </button>
        </div>

        {{-- Jenis Kendaraan --}}
        <div style="min-width: 180px;">
            <select name="jenis_kendaraan" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Jenis Kendaraan</option>
                <option value="mobil" {{ request('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="motor" {{ request('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                <option value="sepeda" {{ request('jenis_kendaraan') == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
                <option value="lainnya" {{ request('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        {{-- Status Kondisi --}}
        <div style="min-width: 180px;">
            <select name="status_kondisi" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Status Kondisi</option>
                <option value="baik" {{ request('status_kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ request('status_kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="hilang" {{ request('status_kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
        </div>

        {{-- Filter Tanggal --}}
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle btn-sm py-1" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" style="height: 32px;">
                Filter Tanggal
            </button>
            <div class="dropdown-menu p-3 shadow-sm" style="min-width: 280px;">
                <div class="mb-2">
                    <label class="form-label mb-1 small">Dari</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label class="form-label mb-1 small">Sampai</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm">
                </div>
                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit" class="btn btn-primary btn-sm py-1" style="height: 32px;">Terapkan</button>
        </div>

        {{-- Reset --}}
        @if(request()->hasAny(['search', 'jenis_kendaraan', 'status_kondisi', 'tanggal_awal', 'tanggal_akhir']))
        <div>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm py-1" style="height: 32px;">Reset</a>
        </div>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="table-responsive px-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No Polisi</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Total Bayar</th>
                    <th>Tipe</th>
                    <th>Total Keuangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keuangan as $item)
                    @php
                        $p = $item->pembayaran;
                        $kendaraan = $p?->kendaraanMasuk?->kendaraan;
                        $masuk = $p?->kendaraanMasuk?->waktu_masuk;
                        $keluar = $p?->kendaraanKeluar?->waktu_keluar;
                    @endphp
                    <tr>
                        <td>{{ $kendaraan->no_polisi ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($masuk)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($keluar)->format('d/m/Y H:i') }}</td>
                        <td><strong>Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $item->tipe == 'pemasukan' ? 'success' : 'danger' }}">
                                {{ ucfirst($item->tipe) }}
                            </span>
                        </td>
                        <td><strong>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data keuangan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $keuangan->appends(request()->query())->links() }}
    </div>
</div>
@endsection
