@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Kendaraan</h5>
            <small class="text-body float-end">Ubah informasi kendaraan</small>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- nopol --}}
            <div class="input-group input-group-merge mb-4">
                <span class="input-group-text"><i class="icon-base ri ri-car-line"></i></span>
                <div class="form-floating form-floating-outline">
                <input type="text" name="no_polisi" value="{{ old('no_polisi', $kendaraan->no_polisi) }}" class="form-control @error('no_polisi') is-invalid @enderror" id="no_polisi" placeholder="D 1234 ABC" />
                <label for="no_polisi">Nomor Polisi</label>
                </div>
                @error('no_polisi')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- JK --}}
            <div class="input-group input-group-merge mb-4">
                <span class="input-group-text"><i class="icon-base ri ri-truck-line"></i></span>
                <div class="form-floating form-floating-outline">
                <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror px-3 py-2">
                    <option selected> Pilih Jenis Kendaraan </option>
                    <option value="motor" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>Motor</option>
                    <option value="mobil" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="sepeda" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
                    <option value="lainnya" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <label for="jenis_kendaraan">Jenis Kendaraan</label>
                </div>
                @error('jenis_kendaraan')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- nama --}}
            <div class="input-group input-group-merge mb-4">
                <span class="input-group-text"><i class="icon-base ri ri-user-line"></i></span>
                <div class="form-floating form-floating-outline">
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $kendaraan->nama_pemilik) }}" class="form-control @error('nama_pemilik') is-invalid @enderror px-3 py-2" id="nama_pemilik" placeholder="Nama Pemilik" />
                <label for="nama_pemilik">Nama Pemilik</label>
                </div>
                @error('nama_pemilik')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- status --}}
            <div class="input-group input-group-merge mb-4">
                <span class="input-group-text"><i class="icon-base ri ri-id-card-line"></i></span>
                <div class="form-floating form-floating-outline">
                <select name="status_pemilik" id="status_pemilik" class="form-select @error('status_pemilik') is-invalid @enderror  px-3 py-2">
                    <option value="">Pilih Status Pemilik /option>
                    <option value="dokter" {{ old('status_pemilik', $kendaraan->status_pemilik) == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="suster" {{ old('status_pemilik', $kendaraan->status_pemilik) == 'suster' ? 'selected' : '' }}>Suster</option>
                    <option value="staff" {{ old('status_pemilik', $kendaraan->status_pemilik) == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="tamu" {{ old('status_pemilik', $kendaraan->status_pemilik) == 'tamu' ? 'selected' : '' }}>Tamu</option>
                </select>
                <label for="status_pemilik">Status Pemilik</label>
                </div>
                @error('status_pemilik')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

            </div>

            <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
@endsection
