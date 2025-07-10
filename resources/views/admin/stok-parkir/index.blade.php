@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center">
        <span>Data Stok Parkir</span>
        <a href="{{ route('stok-parkir.create') }}" class="btn btn-sm btn-primary">+ Tambah Data</a>
    </h5>

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
                                <a class="dropdown-item" href="{{ route('stok-parkir.edit', $data->id) }}">
                                    <i class="ri ri-pencil-line me-1"></i> Edit
                                </a>
                                <form action="{{ route('stok-parkir.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
