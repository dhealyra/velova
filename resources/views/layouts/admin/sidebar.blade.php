<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('home') }}" class="app-brand-link">
      <span class="app-brand-logo demo me-1">
        <span class="text-primary">
          
        </span>
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">Velova</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  @php
  $role = auth()->user()->role;

  $menus = [
      [
          'title' => 'Dashboard',
          'icon' => 'ri-dashboard-line',
          'route' => route('home'),
          'routeName' => 'home',
          'roles' => [0, 1],
      ],
      [
          'title' => 'Data Kendaraan',
          'icon' => 'ri-car-line',
          'route' => route('admin.kendaraan.index'),
          'routeName' => 'admin.kendaraan.index',
          'roles' => [1],
      ],
      [
          'title' => 'Stok Parkir',
          'icon' => 'ri-parking-box-line',
          'route' => route('admin.stok-parkir.index'),
          'routeName' => 'admin.stok-parkir.index',
          'roles' => [1],
      ],
      [
          'title' => 'Parkir Masuk',
          'icon' => 'ri-login-box-line',
          'route' => route('parkir.index'),
          'routeName' => 'parkir.index',
          'roles' => [0, 1],
      ],
      [
          'title' => 'Kendaraan Keluar',
          'icon' => 'ri-logout-box-line',
          'route' => route('kendaraanKeluar.index'),
          'routeName' => 'kendaraanKeluar.index',
          'roles' => [0, 1],
      ],
      [
          'title' => 'Keuangan',
          'icon' => 'ri-money-dollar-box-line',
          'route' => route('admin.transaksi.index'),
          'routeName' => 'admin.transaksi.index',
          'roles' => [0, 1],
      ],
      [
          'title' => 'Kompensasi',
          'icon' => 'ri-shield-user-line',
          'route' => route('kompensasi.index'),
          'routeName' => 'kompensasi.index',
          'roles' => [0, 1],
      ],
  ];
@endphp

<ul class="menu-inner py-1">
  @foreach($menus as $menu)
    @if(in_array($role, $menu['roles']))
      <li class="menu-item {{ request()->routeIs($menu['routeName']) ? 'active' : '' }}">
        <a href="{{ $menu['route'] }}" class="menu-link">
          <i class="menu-icon tf-icons ri {{ $menu['icon'] }}"></i>
          <div>{{ $menu['title'] }}</div>
        </a>
      </li>
    @endif
  @endforeach

  <!-- Logout -->
  <li class="menu-item">
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="menu-link btn border-0 bg-transparent text-start">
        <i class="menu-icon tf-icons ri ri-logout-circle-line"></i>
        Logout
      </button>
    </form>
  </li>
</ul>

</aside>
