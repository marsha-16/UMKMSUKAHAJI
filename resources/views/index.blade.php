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
        <a class="navbar-brand d-flex align-items-center text-white" href="#page-top">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UMKM" style="height:40px; margin-right:10px;">
            <span class="fw-bold">UMKM Sukahaji, Go Digital</span>
        </a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#pelayanan">Pelayanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#katalog">Katalog</a></li>
                <li class="nav-item"><a class="nav-link" href="#hubungi">Hubungi</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ================= MASTHEAD (SETENGAH LAYAR) ================= -->
<header class="masthead" id="home">
    <div id="bgCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(\App\Models\Background::all() as $key => $bg)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="carousel-bg">
                    <img src="{{ asset($bg->image) }}" alt="Background" class="bg-image">
                    <div class="overlay"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container masthead-content text-center text-white">
        <h1>Selamat Datang di UMKM Sukahaji</h1>
        <p>Media informasi untuk mengenal, mendukung, dan memajukan UMKM di Kelurahan Sukahaji</p>
        <a href="{{ route('auth.login') }}" class="btn btn-primary">LOGIN</a>
    </div>
</header>

<!-- ================= TENTANG ================= -->
<section class="page-section bg-primary" id="tentang">
    <div class="container text-center">
        <h2 class="text-white mt-0">UMKM Sukahaji, Berkarya untuk Negeri!</h2>
        <hr class="divider divider-light" />
        <p class="text-white-75 mb-4">
            "Kelurahan Sukahaji memiliki potensi UMKM yang luar biasa. Bersama, kita wujudkan kemandirian ekonomi masyarakat melalui inovasi dan kreativitas pelaku usaha lokal."
        </p>
    </div>
</section>

<!-- ================= LAYANAN ================= -->
<section class="page-section" id="pelayanan">
    <div class="container text-center">
        <h2 class="mt-0">Layanan Kami untuk UMKM Sukahaji</h2>
        <hr class="divider" />
        <div class="row gx-4 gx-lg-5">
            <div class="col-lg-3 col-md-6 mb-4"><div class="mt-5"><div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div><h3 class="h4 mb-2">Produk Unggul</h3><p class="text-muted mb-0">Kualitas terbaik dari pelaku UMKM lokal.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="mt-5"><div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div><h3 class="h4 mb-2">Inovatif & Kreatif</h3><p class="text-muted mb-0">Selalu menghadirkan ide dan produk terbaru.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="mt-5"><div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div><h3 class="h4 mb-2">Siap Go Digital</h3><p class="text-muted mb-0">Produk UMKM Sukahaji siap merambah pasar lebih luas.</p></div></div>
            <div class="col-lg-3 col-md-6 mb-4"><div class="mt-5"><div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div><h3 class="h4 mb-2">Dibuat dengan Cinta</h3><p class="text-muted mb-0">Dari kreativitas dan ketulusan warga Sukahaji.</p></div></div>
        </div>
    </div>
</section>

<!-- ================= KATALOG PRODUK ================= -->
<section class="page-section bg-light" id="katalog">
    <div class="container py-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6">Katalog Produk UMKM</h2>
            <p class="text-secondary">Temukan produk unggulan UMKM terbaik di Sukahaji</p>
        </div>

        <!-- Search & Filter -->
        <form method="GET" action="#katalog" class="row g-2 mb-4 justify-content-center">
            <div class="text-center mt-4">
                <a href="{{ route('katalog') }}" class="btn btn-warning btn-lg fw-semibold text-dark shadow-sm">
                    Lihat Produk
                </a>
            </div>
        </form>

        <!-- Produk Grid -->
        <div class="row">
            @forelse($katalogs as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="overflow-hidden rounded-top">
                            <img src="{{ asset($item->image ?? 'images/noimage.png') }}" class="card-img-top" alt="{{ $item->name }}">
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $item->name }}</h5>
                            <p class="text-muted small mb-2">{{ Str::limit($item->description, 60) }}</p>
                            <p class="fw-bold text-dark mb-3">
                                {{ $item->price && $item->price != 0 ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}
                            </p>
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
    </div>
</section>


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
    color: #fff !important; /* putih */
    font-weight: 600;
    margin: 0 6px;
    transition: color 0.3s ease;
}

.nav-link:hover,
.nav-link.active {
    color: #f6c23e !important; /* kuning saat aktif atau hover */
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
#katalog {
    background-color: #f4623a !important; /* oranye */
    color: #fff;
    padding-top: 80px;
    padding-bottom: 80px;
}

/* Warna teks di dalam section katalog */
#katalog h2,
#katalog p {
    color: #fff !important;
}

/* Tombol 'Lihat Produk' */
.btn-katalog {
    background-color: #fff;
    color: #f4623a;
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-katalog:hover {
    background-color: #ff9f43; /* oranye muda saat hover */
    color: #fff;
}

/* Kartu produk */
.product-card {
    background: #fff;
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

/* Responsive */
@media (max-width: 767.98px) {
    .product-card img {
        height: 180px;
    }
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

#katalog .product-card {
    color: #212529 !important;
}
#katalog .product-card h5,
#katalog .product-card p,
#katalog .product-card .fw-bold {
    color: #212529 !important;
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
    // Saat tombol detail diklik
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = JSON.parse(this.getAttribute('data-item'));
            
            // Isi data ke dalam modal
            document.getElementById('detailName').textContent = item.name;
            document.getElementById('detailPrice').textContent =
                item.price && item.price != 0
                    ? 'Rp ' + Number(item.price).toLocaleString('id-ID')
                    : '-';
            document.getElementById('detailDescription').textContent = item.description ?? '-';
            document.getElementById('detailAddress').textContent = item.address ?? '-';
            document.getElementById('detailPhone').textContent =
                item.phone && item.phone.trim() !== ''
                    ? item.phone
                    : '-';
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