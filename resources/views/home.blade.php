@extends('layouts.admin')

@section('content')
<div class="row">
    <!-- Welcome card -->
    <div class="col-12 mb-4">
        <div class="card position-relative overflow-hidden">
            <div class="card-body text-nowrap d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="row w-100">
                    <div class="col-md-6">
                        <div>
                            <h4 class="card-title mb-2 d-flex align-items-center">
                                <i class="ri-user-smile-line text-success me-2 fs-4"></i>
                                Selamat Datang, {{ ucwords(Auth::user()->name) }}!
                            </h4>
                            <p class="mb-1 text-muted">Semoga harimu menyenangkan 😎</p>
                            <p class="mb-3 small text-muted">Gunakan dashboard ini buat pantau data kendaraan & performa sistem 🚗📊</p>
                        </div>
                    </div>
                    <div class="col-md-6 text-end pe-md-6">
                        <img
                            src="{{ asset('admin/assets/img/illustrations/welcome.png') }}"
                            class="img-fluid d-none d-md-inline-block"
                            alt="Welcome Illustration"
                            style="max-width: 120px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Kendaraan -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">
                    <i class="ri-bar-chart-grouped-line me-1 text-primary"></i> Data Kendaraan
                </h5>
                <span class="small text-muted">
                    <i class="ri-time-line me-1"></i>Update terakhir hari ini
                </span>
            </div>
            <div class="card-body">
                <div class="row justify-content-center text-center">
                    @foreach ([['Kendaraan', $total, 'ri-car-line', 'primary'],
                              ['Stok Parkir', $stokParkir, 'ri-parking-box-line', 'info'],
                              ['Kendaraan Masuk', $masukHariIni, 'ri-login-box-line', 'success'],
                              ['Kendaraan Keluar', $keluarHariIni, 'ri-logout-box-line', 'warning'],
                              ['Rusak', $rusak, 'ri-error-warning-line', 'danger'],
                              ['Hilang', $hilang, 'ri-close-circle-line', 'dark']] as [$label, $value, $icon, $color])
                    <div class="col-md-2 col-4 mb-3">
                        <div class="d-flex flex-column align-items-center">
                            <div class="avatar mb-2">
                                <div class="avatar-initial bg-{{ $color }} rounded-circle shadow">
                                    <i class="ri {{ $icon }} icon-24px text-white"></i>
                                </div>
                            </div>
                            <small class="text-muted">{{ $label }}</small>
                            <h6 class="mb-0">{{ $value }}</h6>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Sidebar -->
    <div class="col-lg-8 mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ri-line-chart-line me-1 text-success"></i> Grafik Kendaraan 7 Hari Terakhir
                </h5>
            </div>
            <div class="card-body">
                <div id="chartLineKendaraan" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4">
        <!-- Jenis Kendaraan -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ri-car-line me-1 text-info"></i> Jenis Kendaraan
                </h5>
            </div>
            <div class="card-body">
                @forelse ($jenis as $key => $value)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ ucfirst($key) }}</span>
                    <strong>{{ $value }}</strong>
                </div>
                @empty
                <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Pendapatan & Kompensasi -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <i class="ri-money-dollar-circle-line me-1 text-warning"></i> Pendapatan
                    </div>
                    <div class="col-3">
                        <h6 class="mb-2">Rp {{ number_format($pendapatan, 2, ',', '.') }}</h6>
                    </div>
                </div>
                <div class="progress bg-label-primary" style="height: 4px;">
                    <div class="progress-bar bg-primary"
                         style="width: {{ $persenPendapatan }}%;"
                         role="progressbar"
                         aria-valuenow="{{ $persenPendapatan }}"
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <i class="ri-refund-2-line me-1 text-danger"></i> Kompensasi
                    </div>
                    <div class="col-3">
                        <h6 class="mb-2">Rp {{ number_format($kompensasi, 2, ',', '.') }}</h6>
                    </div>
                </div>
                <div class="progress bg-label-danger" style="height: 4px;">
                    <div class="progress-bar bg-danger"
                         style="width: {{ $persenKompensasi }}%;"
                         role="progressbar"
                         aria-valuenow="{{ $persenKompensasi }}"
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const chartData = @json($chartData);

    const options = {
        chart: { type: 'line', height: 300, toolbar: { show: false } },
        series: [
            { name: 'Masuk', data: chartData.map(item => item.masuk) },
            { name: 'Keluar', data: chartData.map(item => item.keluar) }
        ],
        xaxis: { categories: chartData.map(item => item.tanggal), title: { text: 'Tanggal' } },
        yaxis: { title: { text: 'Jumlah Kendaraan' } },
        colors: ['#00b894', '#d63031'],
        stroke: { curve: 'smooth' },
        markers: { size: 4 },
        tooltip: { shared: true, intersect: false }
    };

    new ApexCharts(document.querySelector("#chartLineKendaraan"), options).render();
</script>
@endpush
