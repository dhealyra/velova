@extends('layouts.admin')

@section('content')
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-center">
        <span>Data Kendaraan</span>
        <a href="{{ route('kendaraan.create') }}" class="btn btn-sm btn-primary">+ Tambah Data</a>
    </h5>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Waktu Masuk</th>
                    <th>No Polisi</th>
                    <th>Jenis Kendaraan</th>
                    <th>Status Pemilik</th>
                    <th>Status Parkir</th>
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
                            {{-- <div class="dropdown-menu">
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
                            </div> --}}
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
