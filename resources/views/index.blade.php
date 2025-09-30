<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sukahaji</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('desain/assets/favicon.ico') }}" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('desain/css/styles.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" style="padding: 0.3rem 1rem;">
            <div class="container">
                <!-- Logo + Nama Kelurahan -->
                <a class="navbar-brand d-flex align-items-center" href="#page-top">
                    <img src="{{ asset('images/logo.png') }}" 
                        alt="Logo UMKM" 
                        style="height:40px; margin-right:10px;">
                    <span class="fw-bold">UMKM Sukahaji, Go Digital</span>
                </a>

                <!-- Toggler Offcanvas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Offcanvas Menu -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" style="width:250px; max-width:70%;">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Menu</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                            <li class="nav-item"><a class="nav-link" href="#services">Pelayanan</a></li>
                            <li class="nav-item"><a class="nav-link" href="#hubungi">Hubungi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Masthead-->
        <header class="masthead">
        <div id="bgCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            @foreach(\App\Models\Background::all() as $key => $bg)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="d-block w-100" 
                    style="background: url('{{ asset($bg->image) }}') center/cover no-repeat; height:100vh;">
                </div>
                </div>
            @endforeach
            </div>
        </div>

            <div class="container text-center text-white" style="position: absolute; top:40%; left:0; right:0;">
                <h1>Selamat Datang</h1>
                <h1>UMKM Sukahaji</h1>
                <p>Media informasi untuk mengenal, mendukung, dan memajukan UMKM di Kelurahan Sukahaji</p>
                    <a href="{{ route('auth.login') }}" class="btn btn-primary">
                        LOGIN
                    </a>
            </div>
        </header>
        <!-- About-->
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
        <!-- Services-->
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
            <!-- Custom Footer -->
            <footer style="background-color:#003d29;" class="text-white pt-5 pb-3" id="hubungi">
                <div class="container">
                    <div class="row gy-4"> <!-- gy-4 kasih jarak vertikal antar kolom di mobile -->

                        <!-- Logo & Alamat -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center">
                    <!-- Logo kiri -->
                    <div class="me-3">
                        <img src="{{ asset('images/logo.sukahaji.png') }}" 
                            alt="Logo Desa" 
                            style="height:80px;">
                    </div>
                    <!-- Teks alamat kanan -->
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

            <!-- Hubungi Kami -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Hubungi Kami</h6>
                <p class="mb-2"><i class="bi-telephone me-2"></i> 081299813667</p>
                <p class="mb-0"><i class="bi-envelope me-2"></i> ksukahaji@gmail.com</p>
            </div>

            <!-- Nomor Telepon Penting -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Nomor Telepon Penting</h6>
                <p class="mb-0">- 081221694123</p>
            </div>
        </div>
    </div>
    <!-- Copyright -->
                <div class="text-center py-3 mt-4" style="background-color: rgba(0,0,0,0.2);">
                    <span>Copyright &copy; Sukahaji {{ date('Y') }}</span>
                </div>
            </footer>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SimpleLightbox plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ assert('desain/js/scripts.js') }}"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>