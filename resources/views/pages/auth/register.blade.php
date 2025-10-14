<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ===== Background Gambar Responsif dengan Overlay Gelap ===== */
        body.bg-register {
            position: relative;
            background-image: url('{{ asset('images/background.jpeg') }}'); /* sesuaikan gambar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Lapisan overlay gelap */
        body.bg-register::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        /* Agar konten di atas overlay */
        .container {
            position: relative;
            z-index: 1;
        }

        /* Kartu utama */
        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 15px;
        }

        /* Tombol custom */
        .btn-custom {
            background-color: #FFD700 !important;
            border: none;
            color: black !important;
            font-weight: 600;
        }

        .btn-custom:hover {
            background-color: #FFEB3B !important;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .col-lg-6.bg-white {
                background: rgba(255, 255, 255, 0.9);
                border-radius: 10px;
            }
            .card {
                margin: 10px;
            }
        }

        .text-center a:hover {
            text-decoration: underline;
            transition: 0.2s;
        }
    </style>
</head>

<body class="bg-register">
    @if ($errors->any())
    <script>
        Swal.fire({
            title: "Terjadi Kesalahan",
            text: "@foreach($errors->all() as $error) {{ $error }}{{ $loop->last ? '.' : ',' }} @endforeach",
            icon: "error"
        });
    </script>
    @endif

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">

        <!-- Outer Row -->
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-4">
                    <div class="card-body p-0">
                        <!-- Nested Row -->
                        <div class="row">
                            <!-- Logo -->
                            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
                                <img src="{{ asset('images/logo.png') }}" 
                                     alt="Logo" 
                                     class="img-fluid rounded-circle" 
                                     style="max-width: 250px; width: 80%;">
                            </div>

                            <!-- Form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900 fw-bold">Halaman Registrasi</h1>
                                    </div>
                                    <form class="user" action="/register" method="POST" 
                                          onsubmit="const btn=document.getElementById('submitBtn'); btn.disabled=true; btn.textContent='Loading...';">
                                        @csrf
                                        @method('POST')

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                                id="inputName" name="name" placeholder="Masukkan Nama Lengkap...">
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="inputEmail" name="email" placeholder="Masukkan Email Anda...">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="inputPassword" placeholder="Masukkan Password">
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button id="submitBtn" type="submit" class="btn btn-custom btn-user btn-block">
                                            Daftar
                                        </button>
                                        <hr>
                                    </form>

                                    <div class="text-center">
                                        <p class="mb-1" style="color:#333; font-size: 0.95rem;">
                                            Sudah punya akun?
                                            <a href="/login" style="color:#D32F2F; font-weight:600; text-decoration:none;">
                                                Login
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
