@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Edit Kendaraan Masuk</h5>
    <small class="text-body float-end">Update data kendaraan terparkir</small>
  </div>

  <div class="card-body">
    <form action="{{ route('parkir.update', $parkir->id) }}" method="POST">
      @csrf
      @method('PUT')

      {{-- Nomor Polisi --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-car-line"></i></span>
        <div class="form-floating form-floating-outline">
          <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $parkir->kendaraan->no_polisi) }}"
              class="form-control @error('plat_nomor') is-invalid @enderror" id="plat_nomor" placeholder="D 1234 ABC" />
          <label for="plat_nomor">Nomor Polisi</label>
        </div>
      </div>
      @error('plat_nomor')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror

      {{-- Jenis Kendaraan --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-truck-line"></i></span>
        <div class="form-floating form-floating-outline">
          <select name="jenis_kendaraan" id="jenis_kendaraan"
              class="form-select @error('jenis_kendaraan') is-invalid @enderror px-2 py-2">
              <option disabled> Pilih Jenis Kendaraan </option>
              <option value="motor" {{ old('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>Motor</option>
              <option value="mobil" {{ old('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>Mobil</option>
              <option value="sepeda" {{ old('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan) == 'sepeda' ? 'selected' : '' }}>Sepeda</option>
              <option value="lainnya" {{ old('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
          <label for="jenis_kendaraan">Jenis Kendaraan</label>
        </div>
      </div>
      @error('jenis_kendaraan')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror

      {{-- Waktu Masuk (readonly) --}}
      <div class="input-group input-group-merge mb-4">
        <span class="input-group-text"><i class="icon-base ri ri-time-line"></i></span>
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('d M Y - H:i') }}" readonly>
          <label for="waktu_masuk">Waktu Masuk</label>
        </div>
      </div>

      <div class="mt-3">
            <a href="{{ route('parkir.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      timer: 2500,
      showConfirmButton: false
    });
  @endif

  @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '{{ session('error') }}',
      timer: 2500,
      showConfirmButton: false
    });
  @endif
</script>
@endpush
