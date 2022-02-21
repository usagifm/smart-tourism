<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <img src="{{ asset('images/logo.png') }}" alt="" srcset="" width="60" height="60">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    {{-- <li class="nav-item">
        sistem administrasi
    </li> --}}

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->routeIs('admin.dashboard')) active @endif">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>
    {{-- <!-- Nav Item - Tables -->
    <li class="nav-item @if (request()->routeIs('users.index')) active @endif">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('Tabel Admin') }}</span></a>
    </li> --}}
    @can('manage_type_vehicle')
        <li class="nav-item @if (request()->routeIs('vehicleType.index')) active @endif">
            <a class="nav-link" href="{{ route('vehicleType.index') }}">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>{{ __('Tipe Kendaraan') }}</span></a>
        </li>
    @endcan

    @can('manage_vehicle')
        <li class="nav-item @if (request()->routeIs('vehicles.index')) active @endif">
            <a class="nav-link" href="{{ route('vehicles.index') }}">
                <i class="fas fa-fw fa-bicycle"></i>
                <span>{{ __('Kendaraan') }}</span></a>
        </li>
    @endcan

    @can('manage_rent_area')
        <li class="nav-item @if (request()->routeIs('rentarea.index')) active @endif">
            <a class="nav-link" href="{{ route('rentarea.index') }}">
                <i class="fas fa-fw fa-file-signature"></i>
                <span>{{ __('Area Penyewaan') }}</span></a>
        </li>
    @endcan

    @can('show_statistic_rent_vehicle')
        <li class="nav-item @if (request()->routeIs('statistic.rent')) active @endif">
            <a class="nav-link" href="{{ route('statistic.rent') }}">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>{{ __('Statistik Penyewaan') }}</span></a>
        </li>
    @endcan

    @can('show_statistic_revenue')
        <li class="nav-item @if (request()->routeIs('statistic.revenue')) active @endif">
            <a class="nav-link" href="{{ route('statistic.revenue') }}">
                <i class="fas fa-fw fa-money-check"></i>
                <span>{{ __('Statistik Pendapatan') }}</span></a>
        </li>
    @endcan
    {{-- <li class="nav-item @if (request()->routeIs('about')) active @endif">
        <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-fw fa-eye"></i>
            <span>{{ __('About') }}</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    @can('manage_user')
        <li class="nav-item @if (request()->is('manage/*')) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                aria-controls="collapseTwo">
                <i class="fas fa-database"></i>
                <span>Management User</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-danger py-2 collapse-inner rounded">
                    @can('manage_customer')
                        <a class="collapse-item text-white" href="{{ route('manage.user.index') }}">User</a>
                    @endcan
                    @can('manage_operator')
                        <a class="collapse-item text-white" href="{{ route('manage.operator.index') }}">Operator</a>
                    @endcan
                    @can('manage_admin')
                        <a class="collapse-item text-white" href="{{ route('admin.index') }}">Admin</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    {{-- <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo" style="padding-top: inherit;">
            <i class="fas fa-fw fa-cog"></i>
            <span>Two-level menu</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Child menu</a>
            </div>
        </div>
    </li> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline pt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
