@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Data Kendaraan Masuk</span>
        <div class="d-flex gap-2">
            <a href="{{ route('kendaraanmasuk.export.excel', request()->query()) }}" target="_blank" class="btn btn-sm btn-success">
                <i class="ri-file-excel-line me-1"></i> Export Excel
            </a>
            <a href="{{ route('kendaraanmasuk.export.pdf', request()->query()) }}" target="_blank" class="btn btn-sm btn-danger">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </a>
            <a href="{{ route('parkir.form') }}" class="btn btn-sm btn-primary">
                + Tambah Data
            </a>
        </div>
    </h5>

    <form method="GET" action="{{ route('parkir.index') }}" class="d-flex flex-column flex-lg-row gap-2 mb-3 align-items-start align-items-lg-end">

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

        <div style="min-width: 160px;">
            <select name="status_parkir" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Default</option>
                <option value="0" {{ request('status_parkir') == '0' ? 'selected' : '' }}>Terparkir</option>
                <option value="1" {{ request('status_parkir') == '1' ? 'selected' : '' }}>Sudah Keluar</option>
            </select>
        </div>


        {{-- 🚘 Jenis Kendaraan --}}
        <div style="min-width: 180px;">
            <select name="jenis_kendaraan" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Jenis Kendaraan</option>
                <option value="mobil" {{ request('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                <option value="motor" {{ request('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                <option value="sepeda" {{ request('jenis_kendaraan') == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
                <option value="lainnya" {{ request('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        {{-- 📅 Dropdown Tanggal Filter --}}
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
                    <th>Waktu Masuk</th>
                    <th>No Polisi</th>
                    <th>Jenis Kendaraan</th>
                    <th>Status Parkir</th>
                    <th>Status Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parkir as $data)
                <tr>
                    <td>{{ $data->waktu_masuk }}</td>
                    <td>
                        @if ($data->kendaraan->no_polisi)
                            {{ $data->kendaraan->no_polisi }}
                        @else
                            {{ ucwords($data->kendaraan->jenis_kendaraan) }}
                        @endif
                    </td>
                    <td>{{ ucwords($data->kendaraan->jenis_kendaraan) }}</td>
                    <td>
                        @if ($data->status_parkir == 1)
                            <span class="badge rounded-pill bg-label-success me-1">Sudah Keluar</span>
                        @else
                            <span class="badge rounded-pill bg-label-warning me-1">Masih Terparkir</span>
                        @endif
                    </td>
                    <td>{{ ucwords($data->kendaraan->status_pemilik) }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow shadow-none" type="button" data-bs-toggle="dropdown">
                                <i class="ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('parkir.edit', $data->id) }}">
                                    <i class="ri ri-pencil-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('parkir.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="ri ri-delete-bin-line me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kendaraan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $parkir->links() }}
    </div>
</div>
@endsection
