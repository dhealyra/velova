@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Input Kendaraan</h5>
            <small class="text-body float-end">Silakan isi data kendaraan</small>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kendaraan.store') }}" method="POST">
                @csrf

                {{-- Nomor Polisi --}}
                <div class="input-group input-group-merge mt-3 mb-1">
                    <span class="input-group-text"><i class="icon-base ri ri-car-line"></i></span>
                    <div class="form-floating form-floating-outline ms-1">
                        <input type="text" name="no_polisi" value="{{ old('no_polisi') }}" class="form-control @error('no_polisi') is-invalid @enderror" id="plat_nomor" placeholder="D 1234 ABC" />
                        <label for="no_polisi">Nomor Polisi</label>
                    </div>
                </div>
                @error('no_polisi')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

                {{-- Jenis Kendaraan --}}
                <div class="input-group input-group-merge mt-3 mb-1">
                    <span class="input-group-text"><i class="icon-base ri ri-truck-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror px-3 py-2">
                            <option value="">Pilih Jenis Kendaraan</option>
                            <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="sepeda" {{ old('jenis_kendaraan') == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
                            <option value="lainnya" {{ old('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                    </div>
                </div>
                @error('jenis_kendaraan')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

                {{-- Nama Pemilik --}}
                <div class="input-group input-group-merge mt-3 mb-1">
                    <span class="input-group-text"><i class="icon-base ri ri-user-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}" class="form-control @error('nama_pemilik') is-invalid @enderror" id="nama_pemilik" placeholder="Nama Pemilik" />
                        <label for="nama_pemilik">Nama Pemilik</label>
                    </div>
                </div>
                @error('nama_pemilik')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

                {{-- Status Pemilik --}}
                <div class="input-group input-group-merge mt-3 mb-1">
                    <span class="input-group-text"><i class="icon-base ri ri-id-card-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <select name="status_pemilik" id="status_pemilik" class="form-select @error('status_pemilik') is-invalid @enderror px-3 py-2">
                            <option value="">Pilih Status Pemilik</option>
                            <option value="dokter" {{ old('status_pemilik') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="suster" {{ old('status_pemilik') == 'suster' ? 'selected' : '' }}>Suster</option>
                            <option value="staff" {{ old('status_pemilik') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="tamu" {{ old('status_pemilik') == 'tamu' ? 'selected' : '' }}>Tamu</option>
                        </select>
                        <label for="status_pemilik">Status Pemilik</label>
                    </div>
                </div>
                @error('status_pemilik')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                <div class="mt-3">
                {{-- Tombol --}}
                <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('plat_nomor').addEventListener('input', function (e) {
    let input = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); // hapus semua karakter aneh

    // regex buat memisahkan huruf & angka: D 1234 AB
    let formatted = input.match(/^([A-Z]?)(\d{0,4})([A-Z]{0,3})$/);
    if (formatted) {
        let bagian1 = formatted[1]; // huruf depan
        let bagian2 = formatted[2]; // angka
        let bagian3 = formatted[3]; // huruf belakang
        e.target.value = [bagian1, bagian2, bagian3].filter(Boolean).join(' ');
    }
});
</script>
@endpush
