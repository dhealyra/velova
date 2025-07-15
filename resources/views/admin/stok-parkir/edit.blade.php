@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Edit Data Stok Parkir</h5>
    <small class="text-body float-end">Ubah informasi stok slot parkir</small>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.stok-parkir.update', $stokParkir->id) }}" method="POST">
      @csrf
      @method('PUT')

      {{-- Jenis Kendaraan --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-truck-line"></i></span>
        <div class="form-floating form-floating-outline">
          <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror  px-3 py-2">
            <option selected disabled>Pilih Jenis Kendaraan</option>
            <option value="motor" {{ old('jenis_kendaraan', $stokParkir->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>Motor</option>
            <option value="mobil" {{ old('jenis_kendaraan', $stokParkir->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>Mobil</option>
            <option value="sepeda" {{ old('jenis_kendaraan', $stokParkir->jenis_kendaraan) == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
          </select>
          <label for="jenis_kendaraan">Jenis Kendaraan</label>
        </div>
      </div>
      @error('jenis_kendaraan')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror

      {{-- Status Pemilik --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-id-card-line"></i></span>
        <div class="form-floating form-floating-outline">
          <select name="status_pemilik" id="status_pemilik" class="form-select @error('status_pemilik') is-invalid @enderror  px-3 py-2">
            <option selected disabled>Pilih Status Pemilik</option>
            <option value="tamu" {{ old('status_pemilik', $stokParkir->status_pemilik) == 'tamu' ? 'selected' : '' }}>Tamu</option>
            <option value="staff" {{ old('status_pemilik', $stokParkir->status_pemilik) == 'staff' ? 'selected' : '' }}>Staff</option>
          </select>
          <label for="status_pemilik">Status Pemilik</label>
        </div>
      </div>
      @error('status_pemilik')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror

      {{-- Kapasitas --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-database-2-line"></i></span>
        <div class="form-floating form-floating-outline">
          <input type="number" name="kapasitas" value="{{ old('kapasitas', $stokParkir->kapasitas) }}" class="form-control @error('kapasitas') is-invalid @enderror  px-3 py-2" id="kapasitas" placeholder="Kapasitas Kendaraan" />
          <label for="kapasitas">Kapasitas</label>
        </div>
      </div>
      @error('kapasitas')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror

      <div class="mt-3">
            <a href="{{ route('admin.stok-parkir.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
  </div>
</div>
@endsection
