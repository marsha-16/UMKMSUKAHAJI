<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Tombol Toggle Sidebar (muncul hanya di HP) -->
    <span class="sidebar-toggle-btn d-lg-none me-3" id="sidebarToggleMobile">
        <i class="fas fa-bars fa-lg"></i>
    </span>

    <!-- ✅ Topbar Search: hanya tampil di Dashboard Admin -->
   @if(request()->routeIs('admin.dashboard'))
    @auth('admin')
    <form action="{{ route('search') }}" method="GET" class="form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search search-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control bg-light border-0 small"
                placeholder="Cari Sesuatu..." value="{{ request('q') }}">
            <div class="input-group-append">
                <button class="btn btn-search-orange" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    @endauth
    @endif
    <!-- ✅ End Search -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                @php
                    use App\Models\Pemetaan;
                    $badgeCount = 0;
                    if (auth('admin')->check()) {
                        $badgeCount = Pemetaan::where('status', 'process')->count();
                    } elseif (auth('web')->check()) {
                        $badgeCount = auth('web')->user()->unreadNotifications->count();
                    }
                @endphp

                @if ($badgeCount > 0)
                    <span class="badge badge-danger badge-counter">{{ $badgeCount }}</span>
                @endif
            </a>

            <!-- Dropdown - Alerts -->
            @if(auth('admin')->check())
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="alertsDropdown">
                    <!-- 🔴 Header notifikasi merah -->
                    <h6 class="dropdown-header bg-notif-header text-white">Pemetaan Baru Masuk</h6>
                    @php
                        $newPemetaans = Pemetaan::where('status', 'process')->latest()->get();
                    @endphp
                    @forelse ($newPemetaans as $pemetaan)
                        <form id="formPemetaan-{{ $pemetaan->id }}" action="/pemetaan/{{ $pemetaan->id }}/read" method="POST">
                            @csrf
                            <!-- 🟠 Latar notifikasi baru oranye lembut -->
                            <div class="dropdown-item d-flex align-items-center notif-orange-bg"
                                 onclick="document.getElementById('formPemetaan-{{ $pemetaan->id }}').submit()">
                                <div class="mr-3">
                                    <!-- ⚫ Ikon notifikasi hitam dengan aksen kuning -->
                                    <div class="icon-circle notif-icon-black">
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $pemetaan->created_at->diffForHumans() }}</div>
                                    <span class="font-weight-bold text-dark">{{ $pemetaan->name }}, Membuat Pemetaan</span>
                                </div>
                            </div>
                        </form>
                    @empty
                        <span class="dropdown-item text-gray-500">Tidak ada Pemetaan baru</span>
                    @endforelse
                    <a class="dropdown-item text-center small text-gray-500" href="/pemetaan">Lihat Semua</a>
                </div>
            @else
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header bg-notif-header text-white">Notifikasi</h6>
                    @foreach (auth('web')->user()->notifications as $notification)
                        @if (is_null($notification->read_at))
                            <form id="formNotification-{{ $notification->id }}" action="/notification/{{ $notification->id }}/read" method="post">
                                @csrf
                                <div class="dropdown-item d-flex align-items-center notif-orange-bg"
                                     onclick="document.getElementById('formNotification-{{ $notification->id }}').submit()">
                                    <div class="mr-3">
                                        <div class="icon-circle notif-icon-black">
                                            <i class="fas fa-file-alt text-warning"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                        <span class="font-weight-bold text-dark">{{ $notification->data['message'] }}</span>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="dropdown-item d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-secondary">
                                        <i class="fas fa-file-alt text-light"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                    <span class="font-weight-bold text-dark">{{ $notification->data['message'] }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <a class="dropdown-item text-center small text-gray-500" href="/notification">Semua Notifikasi</a>
                </div>
            @endif
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        @php
            if(auth('admin')->check()){
                $authUser = auth('admin')->user();
            } else {
                $authUser = auth('web')->user();
            }
        @endphp

        @auth
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ $authUser->name }}
                </span>

                @if($authUser && $authUser->photo && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $authUser->photo))
                    <img src="{{ asset($authUser->photo) }}" 
                        class="rounded-circle border border-warning"
                        width="40" height="40" alt="Foto Profil">
                @else
                    <div class="d-flex justify-content-center align-items-center bg-light rounded-circle border border-warning"
                        style="width:40px; height:40px;">
                        <i class="fas fa-user text-warning" style="font-size:18px;"></i>
                    </div>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profil
                </a>
                <a class="dropdown-item" href="/change-password">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
            </div>
        </li>
        @endauth
    </ul>
</nav>

<style>
/* 🟠 Tombol Search Oranye Lembut */
.btn-search-orange {
    background-color: #FFA726 !important;
    border: #FFF;
}
.btn-search-orange:hover {
    background-color: #E53935 !important;
}

/* 🔴 Header Notifikasi Merah */
.bg-notif-header {
    background-color: #FB8C00 !important;
}

/* 🟠 Efek Hover Notifikasi: teks jadi putih */
.notif-orange-bg {
    transition: all 0.3s ease;
}
.notif-orange-bg:hover {
    background-color: #FFA726 !important;
    color: #fff !important;
}
.notif-orange-bg:hover * {
    color: #fff !important;
}

/* ⚫ Ikon Notifikasi Hitam dengan Aksen Kuning */
.notif-icon-black {
    background-color: #FB8C00 !important;
    color: #fff;
}

/* Responsif Search */
@media (max-width: 768px) {
    .search-form {
        margin-left: 10px;
        flex: 1;
    }
    .search-form .input-group {
        width: 100%;
    }
}
</style>
