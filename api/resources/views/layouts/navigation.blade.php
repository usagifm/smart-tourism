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
    <li class="nav-item @if(request()->routeIs('home')) active @endif">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>
    {{--
    <!-- Nav Item - Tables -->
    <li class="nav-item @if(request()->routeIs('users.index')) active @endif">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('Users') }}</span></a>
    </li> --}}

    <li class="nav-item @if(request()->routeIs('vehicles.index')) active @endif">
        <a class="nav-link" href="{{ route('vehicles.index') }}">
            <i class="fas fa-fw fa-bicycle"></i>
            <span>{{ __('Vehicle') }}</span></a>
    </li>

    <li class="nav-item @if(request()->routeIs('statistic')) active @endif">
        <a class="nav-link" href="{{ route('statistic') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>{{ __('Statistik') }}</span></a>
    </li>
    {{--
    <li class="nav-item @if(request()->routeIs('about')) active @endif">
        <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-fw fa-eye"></i>
            <span>{{ __('About') }}</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    {{--
    <!-- Nav Item - Pages Collapse Menu -->
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
