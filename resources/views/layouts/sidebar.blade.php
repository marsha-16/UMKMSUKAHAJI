@php
    $menus = [
        // Role 1 = Admin
        1 => [
            (object) ['title' => 'Dashboard','path' => 'dashboardAdmin','icon' => 'fas fa-fw fa-home'],
            (object) ['title' => 'Tentang UMKM Sukahaji','path' => 'admin/tentang','icon' => 'fas fa-fw fa-lightbulb'],
            (object) ['title' => 'Data Penduduk','path' => 'umkm','icon' => 'fas fa-fw fa-table'],
            (object) ['title' => 'Data Pemetaan UMKM','path' => 'pemetaan','icon' => 'fas fa-fw fa-scroll'],
            (object) ['title' => 'Katalog','path' => 'admin/katalog','icon' => 'fas fa-fw fa-shopping-cart'],
            (object) ['title' => 'Masthead','path' => 'admin/backgrounds','icon' => 'fas fa-layer-group'],
            (object) [
                'title' => 'Akun','icon' => 'fas fa-fw fa-user-shield',
                'children' => [
                    (object) ['title' => 'Daftar Akun','path' => 'account-list'],
                    (object) ['title' => 'Permintaan Akun','path' => 'account-request'],
                ],
            ],
            (object) [
                'title' => 'Profil','icon' => 'fas fa-fw fa-user-circle',
                'children' => [
                    (object) ['title' => 'Edit Profile','path' => 'profile'],
                    (object) ['title' => 'Edit Password','path' => 'change-password'],
                ],
            ],
        ],

        // Role 2 = User
        2 => [
            (object) ['title' => 'Dashboard','path' => 'dashboard','icon' => 'fas fa-fw fa-home'],
            (object) ['title' => 'Tentang UMKM Sukahaji','path' => 'tentang-umkm','icon' => 'fas fa-fw fa-lightbulb'],
            (object) ['title' => 'Pemetaan UMKM Sukahaji','path' => 'pemetaan','icon' => 'fas fa-fw fa-scroll'],
            (object) ['title' => 'Katalog','path' => 'katalog-user','icon' => 'fas fa-fw fa-shopping-cart'],
            (object) [
                'title' => 'Profil','icon' => 'fas fa-fw fa-user-circle',
                'children' => [
                    (object) ['title' => 'Edit Profile','path' => 'profile'],
                    (object) ['title' => 'Edit Password','path' => 'change-password'],
                ],
            ],
        ],
    ]; 
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion animated-sidebar" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex flex-column align-items-center justify-content-center text-center" href="/dashboard">
        <div class="sidebar-brand-icon mb-0">
            <img src="{{ asset('images/logo.png') }}" 
                 alt="Logo" 
                 class="img-fluid rounded-circle">
        </div>
        <div class="text-white mt-0">
            <span class="fw-bold">Go Digital</span>
        </div>
    </a><br>

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
                        if(request()->is($child->path . '*')) $isOpen = true;
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ $isOpen ? '' : 'collapsed' }}" 
                       href="#" data-bs-toggle="collapse" 
                       data-bs-target="#collapse{{ Str::slug($menu->title) }}" 
                       aria-expanded="{{ $isOpen ? 'true' : 'false' }}" 
                       aria-controls="collapse{{ Str::slug($menu->title) }}">
                        <span><i class="{{ $menu->icon }}"></i> {{ $menu->title }}</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <div id="collapse{{ Str::slug($menu->title) }}" 
                         class="collapse {{ $isOpen ? 'show' : '' }}" 
                         data-bs-parent="#accordionSidebar">
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
</ul>

<style>
/* === Background animasi === */
.animated-sidebar {
    background: linear-gradient(135deg, #f7c948, #f59e0b, #dc2626, #111827);
    background-size: 300% 300%;
    animation: sidebarGradient 8s ease infinite;
}
@keyframes sidebarGradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* === Logo & Go Digital === */
.sidebar-brand {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    padding-top: 1.2rem !important;
    padding-bottom: 0.4rem !important;
    margin-bottom: 0.4rem !important;
}
.sidebar-brand-icon img {
    display: block !important;
    max-width: 75px !important;
    height: auto !important;
    margin: 0 auto 0.1rem auto !important;
}
.sidebar-brand span {
    font-size: 0.9rem !important;
    letter-spacing: 0.5px !important;
    color: rgba(255, 255, 255, 0.95) !important;
    line-height: 1.1 !important;
}

/* Divider */
.sidebar-divider.my-2 {
    margin-top: 0.25rem !important;
    margin-bottom: 0.9rem !important;
    border-top: 1px solid rgba(255,255,255,0.25) !important;
}

/* === Warna teks & ikon === */
.navbar-nav.sidebar .nav-link,
.navbar-nav.sidebar .nav-link span,
.navbar-nav.sidebar .nav-item .nav-link i {
    color: #fff !important;
    transition: 0.3s ease;
}

/* === Link aktif === */
.navbar-nav.sidebar .nav-link.active-link {
    background: rgba(255, 255, 255, 0.25);
    border-radius: 8px;
    font-weight: bold;
    box-shadow: inset 4px 0 0 #f7c948;
}
.navbar-nav.sidebar .nav-link.active-link i {
    color: #fff !important;
}

/* Hover */
.navbar-nav.sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 8px;
}
.navbar-nav.sidebar .nav-link:hover i {
    transform: rotate(-10deg) scale(1.1);
}

/* === Submenu === */
.collapse-inner .collapse-item {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
}
.collapse-inner .collapse-item:hover {
    background: rgba(255, 255, 255, 0.1);
}
.collapse-inner .collapse-item.active-link {
    font-weight: bold;
    color: #000 !important;
}

/* === Responsif === */
@media (max-width: 992px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 190px;
        z-index: 1050;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    .sidebar.active { transform: translateX(0); }

    .sidebar-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        display: none;
    }
    .sidebar-overlay.show { display: block; }

    /* === Logo di HP === */
    .sidebar-brand-icon img { max-width: 55px !important; }
    .sidebar-brand span { font-size: 0.8rem !important; }

    /* === Submenu muncul ke bawah (tidak ke samping) === */
    .collapse {
        position: static !important;
        transform: none !important;
        visibility: visible !important;
    }
    .collapse-inner {
        padding-left: 1rem !important;
        border-left: 2px solid rgba(255,255,255,0.3);
        background: transparent !important;
    }
}

/* === Extra kecil === */
@media (max-width: 480px) {
    .sidebar { width: 170px; }
    .sidebar-brand-icon img { max-width: 50px !important; }
    .sidebar-brand span { font-size: 0.75rem !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.createElement('div');
    overlay.classList.add('sidebar-overlay');
    document.body.appendChild(overlay);

    const toggleBtn = document.getElementById('sidebarToggleMobile');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('show');
        });
    }

    overlay.addEventListener('click', function() {
        sidebar.classList.remove('active');
        overlay.classList.remove('show');
    });
});
</script>
