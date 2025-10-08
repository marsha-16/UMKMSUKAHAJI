<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sukahaji</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('desain/assets/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <link href="{{ asset('desain/css/styles.css') }}" rel="stylesheet" />
</head>
<body id="page-top">

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center text-white" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UMKM" style="height:40px; margin-right:10px;">
            <span class="fw-bold">UMKM Sukahaji, Go Digital</span>
        </a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/#home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#tentang') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#pelayanan') }}">Pelayanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#katalog">Katalog</a></li>
                <li class="nav-item"><a class="nav-link" href="#hubungi">Hubungi</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ================= KATALOG PRODUK ================= -->
<section class="page-section" id="katalog" style="background-color: #fff7d6;">
    <div class="container py-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6">Katalog Produk UMKM</h2>
            <p class="text-secondary">Temukan produk unggulan UMKM terbaik di Sukahaji</p>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('katalog') }}" class="row g-2 mb-4 justify-content-center">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control form-control-lg shadow-sm"
                    placeholder="🔍 Cari produk..." value="{{ request('search') }}">
            </div>
            <div class="col-6 col-md-2">
                <input type="number" name="min_price" class="form-control form-control-lg shadow-sm"
                    placeholder="Harga Min" value="{{ request('min_price') }}">
            </div>
            <div class="col-6 col-md-2">
                <input type="number" name="max_price" class="form-control form-control-lg shadow-sm"
                    placeholder="Harga Max" value="{{ request('max_price') }}">
            </div>
            <div class="col-6 col-md-2 d-grid">
                <button class="btn btn-warning btn-lg fw-semibold shadow-sm text-dark">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
            </div>
            <div class="col-6 col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-secondary btn-lg fw-semibold shadow-sm" name="reset" value="1">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </button>
            </div>
        </form>

        <!-- Produk Grid -->
        <div class="row">
            @forelse($katalogs as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="overflow-hidden rounded-top">
                        @if($item->image)
                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                        @else
                            <img src="{{ asset('images/noimage.png') }}" class="card-img-top" alt="No Image">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $item->name }}</h5>
                        <p class="text-muted small mb-2">{{ Str::limit($item->description, 60) }}</p>
                        <p class="fw-bold text-dark mb-3">Rp {{ number_format($item->price,0,',','.') }}</p>
                        <button type="button" class="btn btn-theme btn-sm mt-auto text-dark fw-semibold btn-detail" data-item='@json($item)'>
                            <i class="bi bi-info-circle"></i> Detail
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center shadow-sm">
                    <i class="bi bi-info-circle-fill"></i> Produk tidak ditemukan.
                </div>
            </div>
        @endforelse
        </div>

        <!-- Info jumlah -->
        <div class="text-center text-muted small mb-3">
            Menampilkan {{ $katalogs->firstItem() }} - {{ $katalogs->lastItem() }} dari total {{ $katalogs->total() }} produk
        </div>

        <!-- Pagination di kanan bawah -->
        <div class="d-flex justify-content-end align-items-center mt-3">
            <div style="display: flex; gap: 5px;">
                {{-- Tombol Prev --}}
                @if ($katalogs->onFirstPage())
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                @else
                    <a href="{{ $katalogs->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                @endif

                {{-- Nomor halaman terbatas 3 --}}
                @php
                    $start = max($katalogs->currentPage() - 1, 1);
                    $end = min($katalogs->currentPage() + 1, $katalogs->lastPage());
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $katalogs->currentPage())
                        <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                    @else
                        <a href="{{ $katalogs->url($page) }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Tombol Next --}}
                @if ($katalogs->hasMorePages())
                    <a href="{{ $katalogs->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                @else
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ================= MODAL DETAIL PRODUK ================= -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-body p-4">
        <div class="row g-4 align-items-center">

          <!-- Gambar Produk -->
          <div class="col-12 col-md-5 text-center">
            <div class="shadow rounded overflow-hidden bg-light p-2 h-100">
              <img id="detailImage" src="" class="img-fluid rounded product-img" alt="Gambar Produk">
            </div>
          </div>

          <!-- Detail Produk -->
          <div class="col-12 col-md-7">
            <div class="card border-0 shadow-sm p-4 h-100 hover-card">
              <h2 id="detailName" class="fw-bold text-dark mb-3"></h2>
              <h4 id="detailPrice" class="fw-bold text-dark mb-3"></h4>
              <p id="detailDescription" class="text-muted mb-3"></p>
              <div class="mb-2">
                <span class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger"></i> Alamat:</span> 
                <span id="detailAddress" class="text-secondary"></span>
              </div>
              <div class="mb-3">
                <span class="fw-bold text-dark"><i class="bi bi-telephone-fill text-warning"></i> Telp:</span> 
                <span id="detailPhone" class="text-secondary"></span>
              </div>
              <button class="btn btn-gradient mt-3" data-bs-dismiss="modal">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Katalog
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ================= FOOTER ================= -->
<footer style="background-color:#003d29;" class="text-white pt-5 pb-3" id="hubungi">
    <div class="container">
        <div class="row gy-4">
            <!-- Logo & Alamat -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex flex-column flex-sm-row align-items-center text-center text-md-start">
                    <img src="{{ asset('images/logo.sukahaji.png') }}" 
                         alt="Logo Desa" 
                         style="height:80px; margin-right:15px;">
                    <div class="mt-3 mt-sm-0">
                        <p class="mb-0 fw-semibold">Jl. H. Zakaria No.24, Kota Bandung</p>
                        <p class="mb-0">Provinsi Jawa Barat, 40221</p>
                    </div>
                </div>
            </div>

            <!-- Hubungi Kami -->
            <div class="col-lg-4 col-md-6 text-center text-md-start">
                <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                <p><i class="bi bi-telephone me-2"></i> 081299813667</p>
                <p><i class="bi bi-envelope me-2"></i> ksukahaji@gmail.com</p>
                <p><i class="bi bi-envelope me-2"></i> kelsukahajicakep@gmail.com</p>
            </div>

            <!-- Nomor Penting -->
            <div class="col-lg-4 text-center text-md-start">
                <h6 class="fw-bold mb-3">Nomor Penting</h6>
                <p>081221694123</p>
            </div>
        </div>
    </div>

    <div class="text-center py-3 mt-4" style="background-color: rgba(0,0,0,0.2);">
        <span>Copyright &copy; Sukahaji {{ date('Y') }}</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* === NAVBAR === */
.custom-navbar {
    background-color: #f4623a !important; /* oranye */
    padding: 0.6rem 1rem;
    transition: all 0.3s ease;
    z-index: 1050; /* supaya selalu di atas konten */
}

.navbar-brand span {
    color: #fff !important;
}

.nav-link {
    color: #fff !important; /* putih default */
    font-weight: 600;
    margin: 0 6px;
    transition: color 0.3s ease;
}

.nav-link:hover,
.nav-link.active {
    color: #f6c23e !important; /* kuning untuk aktif & hover */
}

/* Biar bagian konten tidak ketutup navbar */
body {
    scroll-padding-top: 70px; /* beri jarak atas saat scroll */
}

/* Masthead (setengah layar) */
.masthead, .carousel-bg { height: 50vh; overflow: hidden; position: relative; }
.bg-image { width: 100%; height: 100%; object-fit: cover; object-position: center; }
.overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); }
.masthead-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; }

/* === KATALOG PRODUK === */
.product-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    min-height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card img {
    height: 220px;
    width: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}

.product-card:hover img {
    transform: scale(1.05);
}

.product-card:hover {
    box-shadow: 0 8px 24px rgba(255,140,0,0.2);
    transform: translateY(-3px);
}

.btn-theme {
    background: linear-gradient(45deg, #ff6b6b, #feca57, #f8c291);
    color: #000;
    border: none;
    font-weight: 600;
}

@media (max-width: 767.98px) {
    .product-card img {
        height: 180px;
    }
}

/* === PAGINATION === */
.pagination {
    justify-content: center;
    gap: 0.4rem;
}

.page-item .page-link {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: #000;
    border: 1px solid #ccc;
}

.page-item.active .page-link {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

/* Responsive */
@media (max-width: 576px){
    .product-card img { height: 180px; }
}
/* Warna background katalog */
#katalog {
    background-color: #fff7d6; /* kuning lembut */
}

/* Tombol kembali (default hitam, hover oranye) */
.btn-dark {
    background-color: #f4623a !important;  /* warna dasar hitam */
    border: none !important;
    transition: all 0.3s ease;
}

.btn-dark:hover {
    background-color: #f4623a !important; /* oranye saat hover */
    color: #fff !important;
}

/* === MODAL DETAIL PRODUK === */
.btn-gradient {
    background: linear-gradient(90deg, #FFC107, #FF5722, #DC3545);
    color: #fff;
    font-weight: 500;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.btn-gradient:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.product-img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}
.product-img:hover {
    transform: scale(1.05);
}

.hover-card:hover {
    background-color: rgba(255, 165, 0, 0.08);
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(255, 87, 34, 0.2);
}

@media (max-width: 992px) {
    .product-img { max-height: 300px; }
}
@media (max-width: 768px) {
    .product-img { max-height: 250px; }
    .btn-gradient { width: 100%; text-align: center; }
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Aktifkan ScrollSpy Bootstrap
    const scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#navbarResponsive',
        offset: 80
    });

    // Smooth scroll ketika menu diklik
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Tambah event listener ke semua menu navbar
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // Hapus class active dari semua link
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Tambahkan class active ke link yang diklik
            this.classList.add('active');

            // Smooth scroll jika menuju section (#)
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Saat tombol detail diklik
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = JSON.parse(this.getAttribute('data-item'));
            
            // Isi data ke dalam modal
            document.getElementById('detailName').textContent = item.name;
            document.getElementById('detailPrice').textContent = 'Rp ' + Number(item.price).toLocaleString('id-ID');
            document.getElementById('detailDescription').textContent = item.description ?? '-';
            document.getElementById('detailAddress').textContent = item.address ?? '-';
            document.getElementById('detailPhone').textContent = item.phone ?? '-';
            document.getElementById('detailImage').src = item.image ? `/${item.image}` : '/images/noimage.png';
            
            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        });
    });
});
</script>

</body>
</html>
