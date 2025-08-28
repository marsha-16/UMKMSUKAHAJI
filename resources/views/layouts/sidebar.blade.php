@php
    $menus = [
        1 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboardAdmin',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Data Penduduk',
                'path' => 'umkm',
                'icon' => 'fas fa-fw fa-table',
            ],
            (object) [
                'title' => 'Data Pemetaan UMKM',
                'path' => 'pemetaan',
                'icon' => 'fas fa-fw fa-scroll',
            ],
            (object) [
                'title' => 'Daftar Akun',
                'path' => 'account-list',
                'icon' => 'fas fa-fw fa-user',
            ],
            (object) [
                'title' => 'Permintaan Akun',
                'path' => 'account-request',
                'icon' => 'fas fa-fw fa-user',
            ],
        ],
        2 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Pemetaan UMKM Sukahaji',
                'path' => 'pemetaan',
                'icon' => 'fas fa-fw fa-scroll',
            ],
        ],
    ]; 
@endphp 
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid rounded-circle" style="max-width: 100px;">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @auth
        @foreach ($menus[auth()->user()->role_id] as $menu)
        <li class="nav-item {{ request()->is($menu->path . '*') ? 'active' : '' }}">
            <a class="nav-link" href="/{{ $menu->path }}">
                <i class="{{ $menu->icon }}"></i>
                <span>{{ $menu->title }}</span>
            </a>
        </li>
    @endforeach
    @endauth    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>