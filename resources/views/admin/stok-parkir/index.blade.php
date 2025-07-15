@extends('layouts.admin')

@section('content')
<div class="card">

    <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Data Stok Parkir</span>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kendaraan.export.excel', request()->all()) }}" target="_blank" class="btn btn-sm btn-success">
                <i class="ri-file-excel-line me-1"></i> Export Excel
            </a>
            <a href="{{ route('admin.stok-parkir.export.pdf', request()->all()) }}" target="_blank" class="btn btn-sm btn-danger">
                <i class="ri-file-pdf-line me-1"></i> Export PDF
            </a>
            <a href="{{ route('admin.stok-parkir.create') }}" class="btn btn-sm btn-primary">+ Tambah Data</a>

        </div>
    </h5>

    <form method="GET" action="{{ route('admin.stok-parkir.index') }}" class="d-flex flex-wrap gap-2 mb-3 align-items-end">

        <div style="min-width: 160px;">
            <select name="status_pemilik" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Semua Pemilik</option>
                <option value="staff" {{ request('status_pemilik') == 'staff' ? 'selected' : '' }}>Pegawai</option>
                <option value="tamu" {{ request('status_pemilik') == 'tamu' ? 'selected' : '' }}>Tamu</option>
            </select>
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

        <div style="min-width: 160px;">
            <select name="sort_kapasitas" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Urut Kapasitas</option>
                <option value="asc" {{ request('sort_kapasitas') == 'asc' ? 'selected' : '' }}>Terkecil</option>
                <option value="desc" {{ request('sort_kapasitas') == 'desc' ? 'selected' : '' }}>Terbesar</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary btn-sm py-1" style="height: 32px;">Terapkan</button>
        </div>

        @if(request()->hasAny(['status_pemilik', 'jenis_kendaraan', 'sort_kapasitas']))
        <div>
            <a href="{{ route('admin.stok-parkir.index') }}" class="btn btn-outline-secondary btn-sm py-1" style="height: 32px;">Reset</a>
        </div>
        @endif
    </form>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover" id="dataOrder">
            <thead>
                <tr>
                    <th>Jenis Kendaraan</th>
                    <th>Status Pemilik</th>
                    <th>Kapasitas</th>
                    <th>Sisa Slot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokParkirs as $data)
                <tr>
                    <td>{{ ucwords($data->jenis_kendaraan) }}</td>
                    <td>{{ ucwords($data->status_pemilik) }}</td>
                    <td>{{ $data->kapasitas }}</td>
                    <td>{{ $data->sisa_slot }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn p-0 dropdown-toggle hide-arrow shadow-none" type="button" data-bs-toggle="dropdown">
                                <i class="ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.stok-parkir.edit', $data->id) }}">
                                    <i class="ri ri-pencil-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.stok-parkir.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    <td colspan="5" class="text-center">Tidak ada data stok parkir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $stokParkirs->links() }}
    </div>
</div>
@endsection
