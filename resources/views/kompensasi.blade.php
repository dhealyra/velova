@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Data Kompensasi</span>
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

    <form method="GET" action="{{ route('kompensasi.index') }}" class="d-flex flex-wrap gap-2 mb-3 align-items-end px-4 mt-2">
        <div style="min-width: 180px;">
            <select name="status_pengajuan" class="form-select form-select-xs py-1" style="height: 32px;">
                <option value="">Status Pengajuan</option>
                <option value="pending" {{ request('status_pengajuan') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ request('status_pengajuan') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status_pengajuan') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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

        @if(request()->hasAny(['status_pengajuan', 'tanggal_awal', 'tanggal_akhir']))
            <div>
                <a href="{{ route('kompensasi.index') }}" class="btn btn-outline-secondary btn-sm py-1" style="height: 32px;">Reset</a>
            </div>
        @endif
    </form>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Plat Nomor</th>
                    <th>Jenis Kerusakan</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kompensasis as $data)
                    <tr>
                        <td>{{ $data->kendaraanKeluar->kendaraanMasuk->kendaraan->no_polisi ?? '-' }}</td>
                        <td>{{ $data->jenis_kompensasi }}</td>
                        <td>Rp {{ number_format($data->kompensasi_disetujui, 0, ',', '.') }}</td>
                        <td>
                            @if ($data->status_pengajuan == 'disetujui')
                                <span class="badge rounded-pill bg-label-success">Disetujui</span>
                            @elseif ($data->status_pengajuan == 'ditolak')
                                <span class="badge rounded-pill bg-label-danger">Ditolak</span>
                            @else
                                <span class="badge rounded-pill bg-label-warning">Pending</span>
                            @endif
                        </td>
                        <td>{{ $data->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn p-0 dropdown-toggle hide-arrow shadow-none" type="button" data-bs-toggle="dropdown">
                                    <i class="ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('kompensasi.edit', $data->id) }}">
                                        <i class="ri ri-pencil-line me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('kompensasi.hapus', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="ri ri-delete-bin-line me-1"></i> Hapus
                                        </button>
                                    </form>
                                    @if (Auth::user()->role == 1)
                                    @if($data->status_pengajuan == 'pending')
                                        <form action="{{ route('admin.kompensasi.setujui', $data->id) }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-success" type="submit">
                                                <i class="ri ri-checkbox-circle-line me-1"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.kompensasi.tolak', $data->id) }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-warning" type="submit">
                                                <i class="ri ri-close-circle-line me-1"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data kompensasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="m-3">
        {{ $kompensasis->links() }}
    </div>
</div>
@endsection
