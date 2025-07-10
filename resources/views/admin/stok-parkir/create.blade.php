@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Input Stok Parkir</h5>
      <small class="text-body float-end">Silakan isi data slot parkir</small>
    </div>
    <div class="card-body">
      <form action="{{ route('stok-parkir.store') }}" method="POST">
        @csrf

        {{-- Jenis Kendaraan --}}
        <div class="input-group input-group-merge mb-4">
          <span class="input-group-text"><i class="icon-base ri ri-truck-line"></i></span>
          <div class="form-floating form-floating-outline">
            <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
              <option selected disabled>Pilih Jenis Kendaraan</option>
              <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
              <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
              <option value="sepeda" {{ old('jenis_kendaraan') == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
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
            <select name="status_pemilik" id="status_pemilik" class="form-select @error('status_pemilik') is-invalid @enderror">
              <option selected disabled>Pilih Status Pemilik</option>
              <option value="tamu" {{ old('status_pemilik') == 'tamu' ? 'selected' : '' }}>Tamu</option>
              <option value="staff" {{ old('status_pemilik') == 'staff' ? 'selected' : '' }}>Staff</option>
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
            <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" placeholder="Kapasitas Kendaraan" />
            <label for="kapasitas">Kapasitas</label>
          </div>
        </div>
        @error('kapasitas')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror

        {{-- Sisa Slot --}}
        <div class="input-group input-group-merge mb-4">
          <span class="input-group-text"><i class="icon-base ri ri-archive-line"></i></span>
          <div class="form-floating form-floating-outline">
            <input type="number" name="sisa_slot" value="{{ old('sisa_slot') }}" class="form-control @error('sisa_slot') is-invalid @enderror" id="sisa_slot" placeholder="Sisa Slot Tersedia" />
            <label for="sisa_slot">Sisa Slot</label>
          </div>
        </div>
        @error('sisa_slot')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
</div>
@endsection
