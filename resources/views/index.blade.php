<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sukahaji</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('desain/assets/favicon.ico') }}" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="{{ asset('desain/css/styles.css') }}" rel="stylesheet" />
</head>
<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top custom-navbar" id="mainNav" style="padding: 0.3rem 1rem;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#page-top">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UMKM" style="height:40px; margin-right:10px;">
            <span class="fw-bold">UMKM Sukahaji, Go Digital</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" 
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#pelayanan">Pelayanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#hubungi">Hubungi</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Masthead -->
<header class="masthead">
    <div id="bgCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(\App\Models\Background::all() as $key => $bg)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="carousel-bg" style="background-image: url('{{ asset($bg->image) }}');">
                    <!-- Overlay untuk blur -->
                    <div class="overlay"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container masthead-content text-center text-white">
        <h1>Selamat Datang</h1>
        <h1>UMKM Sukahaji</h1>
        <p>Media informasi untuk mengenal, mendukung, dan memajukan UMKM di Kelurahan Sukahaji</p>
        <a href="{{ route('auth.login') }}" class="btn btn-primary">LOGIN</a>
    </div>
</header>

<!-- About Section -->
<section class="page-section bg-primary" id="about">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white mt-0">UMKM Sukahaji, Berkarya untuk Negeri!</h2>
                <hr class="divider divider-light" />
                <p class="text-white-75 mb-4">"Kelurahan Sukahaji memiliki potensi UMKM yang luar biasa. Bersama, kita wujudkan kemandirian ekonomi masyarakat melalui inovasi dan kreativitas pelaku usaha lokal."</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="page-section" id="services">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center mt-0">Layanan Kami untuk UMKM Sukahaji</h2>
        <hr class="divider" />
        <div class="row gx-4 gx-lg-5">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Produk Unggul</h3>
                    <p class="text-muted mb-0">Kualitas terbaik dari pelaku UMKM lokal.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Inovatif & Kreatif</h3>
                    <p class="text-muted mb-0">Selalu menghadirkan ide dan produk terbaru.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Siap Go Digital</h3>
                    <p class="text-muted mb-0">Produk UMKM Sukahaji siap merambah pasar lebih luas.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Dibuat dengan Cinta</h3>
                    <p class="text-muted mb-0">Produk UMKM Sukahaji lahir dari kreativitas dan ketulusan warga.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer style="background-color:#003d29;" class="text-white pt-5 pb-3" id="hubungi">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('images/logo.sukahaji.png') }}" alt="Logo Desa" style="height:80px;">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Kelurahan Sukahaji</h5>
                        <p class="mb-0">
                            Alamat Kantor Kelurahan Sukahaji <br>
                            Jl. H. Zakaria No.24, Kota Bandung<br>
                            Provinsi Jawa Barat, 40221
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Hubungi Kami</h6>
                <p class="mb-2"><i class="bi-telephone me-2"></i> 081299813667</p>
                <p class="mb-0"><i class="bi-envelope me-2"></i> ksukahaji@gmail.com</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Nomor Telepon Penting</h6>
                <p class="mb-0">- 081221694123</p>
            </div>
        </div>
    </div>
    <div class="text-center py-3 mt-4" style="background-color: rgba(0,0,0,0.2);">
        <span>Copyright &copy; Sukahaji {{ date('Y') }}</span>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
<script src="{{ asset('desain/js/scripts.js') }}"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

<style>
/* Navbar */
.custom-navbar {
    background-color: #004d26 !important;
}

/* Masthead */
.masthead .masthead-content {
    position: absolute;
    top: 40%;
    left: 0; right: 0;
    padding: 0 15px;
    text-align: center;
}

.masthead h1 { font-size: 1.8rem; }
.masthead p { font-size: 1rem; }

@media (min-width: 768px) {
    .masthead h1 { font-size: 2.5rem; }
    .masthead p { font-size: 1.2rem; }
}
@media (min-width: 1200px) {
    .masthead h1 { font-size: 3.5rem; }
}

/* Carousel background */
.carousel-bg {
    height: 100vh;
    background-size: cover;
    background-position: center;
    position: relative;
}

.carousel-bg .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0,0,0,0.4); /* gelap & blur */
    backdrop-filter: blur(5px);
}

.carousel-item, .carousel-item .carousel-bg {
    height: 100vh;
    min-height: 400px;
}

/* Divider */
.divider {
    width: 60px;
    height: 3px;
    background-color: #ffffff;
    margin: 1.5rem auto;
    border-radius: 2px;
}
</style>

</body>
</html>
