@php
    $menus = [
        // Role 1 = Admin
        1 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboardAdmin',
                'icon' => 'fas fa-fw fa-home',
            ],
            (object) [
                'title' => 'Tentang UMKM Sukahaji',
                'path' => 'admin/tentang',   // ✅ ganti ke prefix admin
                'icon' => 'fas fa-fw fa-lightbulb',
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
                'title' => 'Katalog',
                'path' => 'admin/katalog',
                'icon' => 'fas fa-fw fa-shopping-cart',
            ],
            (object) [
                'title' => 'Masthead',
                'path' => 'admin/backgrounds',
                'icon' => 'fas fa-layer-group',
            ],
            (object) [
                'title' => 'Akun',
                'icon' => 'fas fa-fw fa-user-shield',
                'children' => [
                    (object) [
                        'title' => 'Daftar Akun',
                        'path' => 'account-list',
                    ],
                    (object) [
                        'title' => 'Permintaan Akun',
                        'path' => 'account-request',
                    ],
                ],
            ],
            (object) [
                'title' => 'Profil',
                'icon' => 'fas fa-fw fa-user-circle',
                'children' => [
                    (object) [
                        'title' => 'Edit Profile',
                        'path' => 'profile',
                    ],
                    (object) [
                        'title' => 'Edit Password',
                        'path' => 'change-password',
                    ],
                ],
            ],
        ],

        // Role 2 = User
        2 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-home',
            ],
            (object) [
                'title' => 'Tentang UMKM Sukahaji',
                'path' => 'tentang-umkm',   // ✅ ganti ke route user
                'icon' => 'fas fa-fw fa-lightbulb',
            ],
            (object) [
                'title' => 'Pemetaan UMKM Sukahaji',
                'path' => 'pemetaan',
                'icon' => 'fas fa-fw fa-scroll',
            ],
            (object) [
                'title' => 'Katalog',
                'path' => 'katalog-user',
                'icon' => 'fas fa-fw fa-shopping-cart',
            ],
            (object) [
                'title' => 'Profil',
                'icon' => 'fas fa-fw fa-user-circle',
                'children' => [
                    (object) [
                        'title' => 'Edit Profile',
                        'path' => 'profile',
                    ],
                    (object) [
                        'title' => 'Edit Password',
                        'path' => 'change-password',
                    ],
                ],
            ],
        ],
    ]; 
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion animated-sidebar" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-start" href="/dashboard">
    <div class="sidebar-brand-icon">
        <img src="{{ asset('images/logo.png') }}" 
             alt="Logo" 
             class="img-fluid rounded-circle me-2" 
             style="max-width: 70px;">
    </div>
    <div class="text-white">
        <span class="fw-bold" style="font-size: 0.9rem;">Go Digital</span>
    </div>
</a>

<hr class="sidebar-divider my-2">

<!-- Main Menu Title -->
<div class="text-light fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; margin-left: 15px;">
    Main Menu
</div>


    <hr class="sidebar-divider my-0">

    @auth
        @foreach ($menus[auth()->user()->role_id] as $menu)
            @if (!empty($menu->children))
                @php
                    $isOpen = false;
                    foreach($menu->children as $child){
                        if(request()->is($child->path . '*')){
                            $isOpen = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ $isOpen ? '' : 'collapsed' }}" href="#" data-bs-toggle="collapse" 
                       data-bs-target="#collapse{{ Str::slug($menu->title) }}" 
                       aria-expanded="{{ $isOpen ? 'true' : 'false' }}" 
                       aria-controls="collapse{{ Str::slug($menu->title) }}">
                        <span><i class="{{ $menu->icon }}"></i> {{ $menu->title }}</span>
                        <i class="fas fa-angle-right"></i> <!-- ikon dropdown kanan -->
                    </a>
                    <div id="collapse{{ Str::slug($menu->title) }}" class="collapse {{ $isOpen ? 'show' : '' }}" data-bs-parent="#accordionSidebar">
                        <div class="bg-transparent py-2 collapse-inner rounded">
                            @foreach ($menu->children as $child)
                                <a class="collapse-item {{ request()->is($child->path . '*') ? 'active-link' : '' }}" href="/{{ $child->path }}">
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @else
                <li class="nav-item {{ request()->is($menu->path . '*') ? 'active' : '' }}">
                    <a class="nav-link {{ request()->is($menu->path . '*') ? 'active-link' : '' }}" href="/{{ $menu->path }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ $menu->title }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    @endauth    

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<style>
/* Sidebar background animasi */
.animated-sidebar {
    background: linear-gradient(135deg, #f7c948, #f59e0b, #dc2626, #111827);
    background-size: 300% 300%;
    animation: sidebarGradient 8s ease infinite;
}
@keyframes sidebarGradient {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Semua teks dan ikon di sidebar */
.navbar-nav.sidebar .nav-link,
.navbar-nav.sidebar .nav-link span,
.navbar-nav.sidebar .nav-item .nav-link i {
    color: #fff !important;
    transition: 0.3s ease;
}

/* Menu utama aktif */
.navbar-nav.sidebar .nav-link.active-link {
    background: rgba(255, 255, 255, 0.25);
    border-radius: 8px;
    font-weight: bold;
    box-shadow: inset 4px 0 0 #f7c948;
    color: #fff !important;
}
.navbar-nav.sidebar .nav-link.active-link i {
    color: #fff !important;
}

/* Hover menu utama */
.navbar-nav.sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    color: #000 !important;
}
.navbar-nav.sidebar .nav-link:hover i {
    transform: rotate(-10deg) scale(1.1);
    color: #fff !important;
}

/* Divider */
.sidebar-divider { border-color: rgba(255,255,255,0.3); }

/* Child menu (submenu) */
.collapse-inner .collapse-item {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    color: red;
    text-decoration: none;
    border-radius: 6px;
}

/* Hover child menu */
.collapse-inner .collapse-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #000 !important;
}

/* Child menu aktif tanpa kotak, teks hitam */
.collapse-inner .collapse-item.active-link {
    font-weight: bold;
    background: transparent; /* hilangkan kotak */
    color: #000 !important;
}

/* Dropdown icon kanan */
.nav-link.d-flex.justify-content-between.align-items-center i.fas.fa-angle-left {
    transition: transform 0.3s ease;
}

/* Rotasi ikon saat submenu terbuka */
.nav-link[aria-expanded="true"] i.fas.fa-angle-left {
    transform: rotate(-90deg);
}

/* ===== Responsif Sidebar di Mobile ===== */
@media (max-width: 992px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 180px; /* Lebar sidebar di HP */
        z-index: 1050;
        overflow-y: auto; /* Supaya bisa scroll */
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    /* Saat sidebar aktif (misal toggle ditekan) */
    .sidebar.active {
        transform: translateX(0);
    }

    /* Overlay hitam transparan di belakang sidebar */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
    }

    .sidebar-overlay.show {
        display: block;
    }

    /* Tombol toggle menu (burger) */
    .sidebar-toggle-btn {
        display: inline-block;
        color: #111;
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: 10px;
    }
}

/* Desktop tetap seperti biasa */
@media (min-width: 992px) {
    .sidebar {
        transform: none !important;
        position: static;
        width: 250px;
    }

    .sidebar-overlay {
        display: none !important;
    }

    .sidebar-toggle-btn {
        display: none;
    }
}

</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.createElement('div');
    overlay.classList.add('sidebar-overlay');
    document.body.appendChild(overlay);

    const toggleBtn = document.getElementById('sidebarToggleMobile');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', function() {
        sidebar.classList.remove('active');
        overlay.classList.remove('show');
    });
});
</script>
