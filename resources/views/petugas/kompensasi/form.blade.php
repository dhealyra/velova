@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Kompensasi Kerusakan</h5>
            <small class="text-body float-end">Isi data kompensasi jika kendaraan rusak</small>
        </div>

        <div class="card-body">
            <form action="{{ route('kompensasi.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="image" class="form-label d-block">Bukti Gambar Kerusakan (Opsional)</label>

                    <label for="image" id="upload-button"
                        class="d-flex align-items-center gap-3 p-3 border-2 border-dashed rounded cursor-pointer bg-light hover-shadow"
                        style="transition: 0.3s ease; cursor: pointer;">
                        <img id="icon-preview" src="https://cdn-icons-png.flaticon.com/512/1829/1829586.png"
                            alt="Upload Icon" style="width: 48px; height: 48px; object-fit: cover;" class="rounded">
                        <span class="text-primary">Klik untuk pilih gambar</span>
                        <input type="file" name="bukti" id="image" accept="image/*" class="d-none" onchange="previewImage(event)">
                    </label>

                    {{-- Tampilkan error jika ada --}}
                    @error('bukti')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Hidden --}}
                <input type="hidden" name="id_kendaraan_keluar" value="{{ $keluar->id }}">

                {{-- Informasi Umum --}}
                <div class="mb-3">
                    <label class="form-label">Nama Pemilik Kendaraan</label>
                    <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror"
                        value="{{ old('nama_pemilik', $keluar->kendaraanmasuk->kendaraan->nama_pemilik ?? '') }}" required>
                    @error('nama_pemilik')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kompensasi --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Kerusakan / Kompensasi</label>
                    <input type="text" name="jenis_kompensasi" class="form-control @error('jenis_kompensasi') is-invalid @enderror"
                        value="{{ ucwords($keluar->status_kondisi) }}" readonly>
                    @error('jenis_kompensasi')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nominal Kompensasi --}}
                <div class="mb-3">
                    <label class="form-label">Nominal Kompensasi (Rp)</label>
                    <input type="number" name="kompensasi_disetujui" class="form-control @error('kompensasi_disetujui') is-invalid @enderror"
                        value="{{ old('kompensasi_disetujui') }}" required>
                    @error('kompensasi_disetujui')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                        rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('icon-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
