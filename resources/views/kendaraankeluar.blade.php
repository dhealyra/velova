@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Data Kendaraan Keluar</span>
        <div class="d-flex gap-2">
            <a href="{{ route('kendaraankeluar.export.excel', request()->query()) }}" target="_blank" class="btn btn-sm btn-success">
                <i class="ri-file-excel-line me-1"></i> Export Excel
            </a>
            <a href="{{ route('kendaraankeluar.export.pdf', request()->query()) }}" target="_blank" class="btn btn-sm btn-danger">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </a>
            <a href="{{ route('kendaraanKeluar.form') }}" class="btn btn-sm btn-primary">
                + Tambah Data
            </a>
        </div>
    </h5>

    <form method="GET" action="{{ route('kendaraanKeluar.index') }}" class="d-flex flex-wrap gap-2 mb-3 align-items-end">
        <div class="position-relative" style="min-width: 180px;">
            <input type="text" name="search" id="search"
                class="form-control form-control-xs pe-5 py-1"
                placeholder="Cari No Polisi / Pemilik..."
                value="{{ request('search') }}"
                style="height: 32px;">
            <button type="submit" class="btn position-absolute top-0 end-0 mt-1 me-3 p-0 border-0 bg-transparent" tabindex="-1">
                <i class="ri-search-line text-muted"></i>
            </button>
        </div>
        <div style="min-width: 180px;">
            <select name="jenis_kendaraan" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Jenis Kendaraan</option>
                <option value="mobil" {{ request('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="motor" {{ request('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                <option value="sepeda" {{ request('jenis_kendaraan') == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
                <option value="lainnya" {{ request('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div style="min-width: 180px;">
            <select name="status_kondisi" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Status Kondisi</option>
                <option value="baik" {{ request('status_kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ request('status_kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="hilang" {{ request('status_kondisi') == 'hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
        </div>

        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle btn-sm py-1" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" style="height: 32px;">
                Filter Tanggal
            </button>
            <div class="dropdown-menu p-3 shadow-sm" style="min-width: 280px;">
                <div class="mb-2">
                    <label for="tanggal_awal" class="form-label mb-1 small">Dari</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal"
                        value="{{ request('tanggal_awal') }}"
                        class="form-control form-control-sm">
                </div>
                <div class="mb-2">
                    <label for="tanggal_akhir" class="form-label mb-1 small">Sampai</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="form-control form-control-sm">
                </div>
                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm py-1" style="height: 32px;">Terapkan</button>
        </div>

        @if(request()->hasAny(['search', 'status_pemilik', 'jenis_kendaraan', 'tanggal_awal', 'tanggal_akhir']))
        <div>
            <a href="{{ route('parkir.index') }}" class="btn btn-outline-secondary btn-sm py-1" style="height: 32px;">Reset</a>
        </div>
        @endif

    </form>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No Polisi</th>
                    <th>Jenis Kendaraan</th>
                    <th>Waktu Keluar</th>
                    <th>Status Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kendaraanKeluar as $item)
                <tr>
                    <td>{{ $item->kendaraanMasuk->kendaraan->no_polisi ?? '-' }}</td>
                    <td>{{ ucfirst($item->kendaraanMasuk->kendaraan->jenis_kendaraan ?? '-') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->waktu_keluar)->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($item->status_kondisi ?? '-') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data kendaraan keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $kendaraanKeluar->links() }}
    </div>
</div>
@endsection
