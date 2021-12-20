<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <img src="{{ asset('images/TubabaPutih.png') }}" alt="" srcset="" width="180">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    {{-- <li class="nav-item">
        sistem administrasi
    </li> --}}

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->routeIs('dashboard')) active @endif">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Sewa Kendaraan') }}</span></a>
    </li>

    <li class="nav-item @if (request()->routeIs('vehicle.history')) active @endif">
        <a class="nav-link" href="{{ route('vehicle.history') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>{{ __('History') }}</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline pt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
