<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

   <!-- Topbar Search (Hanya Admin) -->
@auth
    @if(auth()->user()->role_id == 1)
        <form action="{{ route('search') }}" method="GET" 
              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" name="q" class="form-control bg-light border-0 small"
                        placeholder="Cari Sesuatu..." value="{{ request('q') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    @endif
@endauth

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS, hanya Admin) -->
    @auth
        @if(auth()->user()->role_id == 1)
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form action="{{ route('search') }}" method="GET" class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control bg-light border-0 small"
                                placeholder="Cari Sesuatu..." value="{{ request('q') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        @endif
    @endauth

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                @php
                use App\Models\Pemetaan;
                $badgeCount = 0;

                if (auth('admin')->check()) {
                    // kalau admin, hitung complain dengan status = new
                    $badgeCount = Pemetaan::where('status', 'process')->count();
                } elseif (auth('web')->check()) {
                        // kalau user biasa, hitung unread notifications
                        $badgeCount = auth('web')->user()->unreadNotifications->count();
                }
            @endphp


            @if ($badgeCount > 0)
                <span class="badge badge-danger badge-counter">
                    {{ $badgeCount }}
                </span>
            @endif
            </a>

            <!-- Dropdown - Alerts -->
            @if(auth('admin')->check())
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Pemetaan Baru Masuk
                </h6>
            @php
                $newPemetaans = Pemetaan::where('status', 'process')->latest()->get();
            @endphp
            
            @forelse ($newPemetaans as $pemetaan)
                <form id="formPemetaan-{{ $pemetaan->id }}" 
                    action="/pemetaan/{{ $pemetaan->id }}/read" 
                    method="POST">
                    @csrf
                    <div class="dropdown-item d-flex align-items-center" 
                        style="background-color: rgba(115, 194, 251, 0.1); cursor: pointer;" 
                        onclick="document.getElementById('formPemetaan-{{ $pemetaan->id }}').submit()">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $pemetaan->created_at->diffForHumans() }}</div>
                            <span class="font-weight-bold">{{ $pemetaan->name }}, Membuat Pemetaan</span>
                        </div>
                    </div>
                </form>
            @empty
                <span class="dropdown-item text-gray-500">Tidak ada Pemetaan baru</span>
            @endforelse
            
        
                <a class="dropdown-item text-center small text-gray-500" href="/pemetaan">Lihat Semua</a>
            </div>
        
            @else
                {{-- User biasa melihat notifikasi --}}
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    @foreach (auth('web')->user()->notifications as $notification)
                        @if (is_null($notification->read_at))
                            <form id="formNotification-{{ $notification->id }}" action="/notification/{{ $notification->id }}/read" method="post">
                                @csrf
                                @method('POST')
                                <div class="dropdown-item d-flex align-items-center" style="background-color: rgba(115, 194, 251, 0.1); cursor: pointer;" onclick="document.getElementById('formNotification-{{ $notification->id }}').submit()">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                        <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="dropdown-item d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                    <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <a class="dropdown-item text-center small text-gray-500" href="/notification">Semua Notifikasi</a>
                </div>
            @endif
            </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        @auth
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name }}
                </span>

                {{-- Avatar --}}
                @if(Auth::guard('admin')->check())
                    {{-- Admin = biru --}}
                    <span class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user-circle text-white"></i>
                    </span>
                @else
                    {{-- User = abu-abu --}}
                    <span class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-user-circle text-white"></i>
                    </span>
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <a class="dropdown-item" href="/change-password">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
        @endauth
    </ul>

</nav>