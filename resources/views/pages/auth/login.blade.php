<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Font & Style -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ===== Background Gambar Responsif dengan Overlay ===== */
        body.bg-user {
            position: relative;
            background-image: url('{{ asset('images/background.jpeg') }}'); /* Ganti sesuai gambar kamu */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Overlay gelap di atas gambar */
        body.bg-user::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        /* Kontainer utama agar di atas overlay */
        .container {
            position: relative;
            z-index: 1;
        }

        /* Card transparan */
        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 15px;
        }

        /* Tombol login */
        .btn-primary {
            background-color: #D32F2F !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #B71C1C !important;
        }

        /* Link style */
        .text-center a:hover {
            text-decoration: underline;
            transition: 0.2s;
        }

        /* Responsif HP */
        @media (max-width: 768px) {
            .col-lg-6.bg-white {
                background: rgba(255, 255, 255, 0.85);
                border-radius: 10px;
            }
            .card {
                margin: 10px;
            }
        }
    </style>
</head>

<body class="bg-user">

    {{-- POPUP LOGIN --}}
    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: "Berhasil Login!",
                text: "{{ session('success') }}",
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
                willClose: () => { window.location.href = "/dashboard"; }
            });
        });
    </script>
    @endif

    @if (session('status_message'))
    <script>
        Swal.fire({
            title: "Pendaftaran Berhasil!",
            text: "{{ session('status_message') }}",
            icon: "info",
            confirmButtonText: "OK",
            confirmButtonColor: "#D32F2F"
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: "Gagal Login!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                title: "Terjadi Kesalahan",
                text: "@foreach($errors->all() as $error) {{ $error }}{{ $loop->last ? '.' : ',' }} @endforeach",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
    @endif

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
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
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-3">Selamat Datang</h1>
                                    </div>
                                    <form class="user" action="/login" method="POST" onsubmit="const btn=document.getElementById('submitBtn');btn.disabled=true;btn.textContent='Loading...'">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="inputEmail" name="email"
                                                placeholder="Masukkan Email...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="inputPassword" placeholder="Password">
                                        </div>
                                        <button id="submitBtn" type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center mt-3">
                                        <p class="mb-1" style="color:#333; font-size: 0.95rem;">
                                            Belum punya akun?
                                            <a href="/register" 
                                               style="color:#D32F2F; font-weight:600; text-decoration:none;">
                                                Buat Akun Baru
                                            </a>
                                        </p>
                                        <p style="color:#333; font-size: 0.95rem;">
                                            Lupa password?
                                            <a href="https://wa.me/6289608905946?text=Halo%20Admin,%20saya%20lupa%20password%20akun%20UMKM%20saya." 
                                               target="_blank" 
                                               style="color:#004b73; font-weight:600; text-decoration:none;">
                                                Hubungi Admin
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
