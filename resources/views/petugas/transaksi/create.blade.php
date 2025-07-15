@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Input Kendaraan</h5>
            <small class="text-body float-end">Silakan isi data kendaraan</small>
        </div>
        <div class="card-body">
            <form action="{{ route('kendaraan.keluar') }}" method="POST">
                @csrf

                <div class="input-group input-group-merge mb-4">
                    <span class="input-group-text"><i class="icon-base ri ri-car-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}"
                            class="form-control @error('plat_nomor') is-invalid @enderror" id="plat_nomor"
                            placeholder="D 1234 ABC" />
                        <label for="plat_nomor">Nomor Polisi</label>
                    </div>
                </div>
                @error('plat_nomor')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Sebab Denda</label>
                    <div class="d-flex flex-wrap gap-3"">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="sebab_denda[]" value="tiket hilang"
                                id="kondisi_tiket" />
                            <label class="form-check-label" for="kondisi_tiket">Tiket Hilang</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="sebab_denda[]" value="merusak"
                                id="kondisi_merusak" />
                            <label class="form-check-label" for="kondisi_merusak">Merusak</label>
                        </div>
                    </div>
                </div>

                <div id="input_denda_manual" class="mb-3" style="display: none;">
                    <label for="denda_manual" class="form-label">Denda Manual (Rp)</label>
                    <input type="number" name="denda_manual" class="form-control" id="denda_manual"
                        placeholder="Masukkan nominal denda manual">
                </div>

                {{-- Checkbox Kondisi Kendaraan --}}
                <div class="mb-3">
                    <label class="form-label">Kondisi Kendaraan</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kondisi[]" value="rusak"
                                id="kondisi_rusak" />
                            <label class="form-check-label" for="kondisi_rusak">Rusak</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kondisi[]" value="kehilangan"
                                id="kondisi_kehilangan" />
                            <label class="form-check-label" for="kondisi_kehilangan">Kehilangan</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- JQUERY WAJIB ADA & HARUS SEBELUM UI --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />

    <script>
        $(function() {
            console.log("✅ Autocomplete script loaded");

            $("#plat_nomor").autocomplete({
                source: function(request, response) {
                    console.log("🚀 Mengirim request AJAX...");
                    $.ajax({
                        url: "{{ route('autocomplete.plat') }}",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            console.log("✅ Data dari server:", data);
                            response(data);
                        },
                        error: function(xhr) {
                            console.error("❌ Error:", xhr);
                        }
                    });
                },
                minLength: 2
            });
        });
    </script>

    <script>
        function cekCheckboxDenda() {
            const isMerusak = $('#kondisi_merusak').is(':checked');
            const isLainnya = false; // kamu bisa tambahin checkbox "lainnya" kalau perlu
            const isTiketHilang = $('#kondisi_tiket').is(':checked');

            // Kalau cuma tiket hilang => hide manual
            if (isTiketHilang && !isMerusak && !isLainnya) {
                $('#input_denda_manual').hide();
            } else if (isMerusak || isLainnya) {
                $('#input_denda_manual').show();
            } else {
                $('#input_denda_manual').hide();
            }
        }

        $(function() {
            $('#kondisi_tiket, #kondisi_merusak').on('change', cekCheckboxDenda);
        });
    </script>



    {{-- SweetAlert untuk feedback --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('kompensasi_prompt'))
        <script>
            Swal.fire({
                title: 'Ajukan Kompensasi?',
                text: "Kendaraan mengalami kondisi tidak baik. Mau ajukan kompensasi?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ajukan',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('kompensasi.form', session('kompensasi_prompt')) }}";
                } else {
                    window.location.href = "{{ route('transaksi.buat', session('kompensasi_prompt')) }}";
                }
            });
        </script>
    @endif

@endpush
