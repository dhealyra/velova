@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Kompensasi</h5>
            <small class="text-body float-end">Perbarui data kompensasi jika diperlukan</small>
        </div>

        <div class="card-body">
            <form action="{{ route('kompensasi.update', $kompensasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Hidden --}}
                <input type="hidden" name="id_kendaraan_keluar" value="{{ $kompensasi->id_kendaraan_keluar }}">

                {{-- Informasi Umum --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pemilik Kendaraan</label>
                    <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror"
                        value="{{ old('nama_pemilik', $kompensasi->nama_pemilik) }}" required>
                    @error('nama_pemilik')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kompensasi --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kerusakan / Kompensasi</label>
                    <input type="text" name="jenis_kompensasi" class="form-control"
                        value="{{ ucwords($kompensasi->jenis_kompensasi) }}" readonly>
                </div>

                {{-- Nominal Kompensasi --}}
                <div class="mb-3">
                    <label class="form-label">Nominal Kompensasi (Rp)</label>
                    <input type="number" name="kompensasi_disetujui" class="form-control @error('kompensasi_disetujui') is-invalid @enderror"
                        value="{{ old('kompensasi_disetujui', $kompensasi->kompensasi_disetujui) }}" required>
                    @error('kompensasi_disetujui')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                        rows="3">{{ old('keterangan', $kompensasi->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
