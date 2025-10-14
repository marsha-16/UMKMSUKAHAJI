<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-custom">
    @if ($errors->any())
    <script>
        Swal.fire({
            title: "Terjadi Kesalahan",
            text: "@foreach($errors->all() as $error) {{ $error }}{{ $loop->last ? '.' : ',' }} @endforeach",
            icon: "error"
        });
    </script>
    @endif
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
                                <img src="{{ asset('images/logo.png') }}" 
                                     alt="Logo" 
                                     class="img-fluid rounded-circle" 
                                     style="max-width: 250px; width: 80%;">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Halaman Registrasi</h1>
                                    </div>
                                    <form class="user" action="/register" method="POST" onsubmit="const submitBtn = document.getElementById('submitBtn'); submitBtn.disabled = true; submitBtn.textContent = 'Loading...' ">
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
                                                id="inputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Masukkan Email Anda...">
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
                                        <button id="submitBtn" type="submit" class="btn btn-custom btn-user btn-block" style="color:black">
                                            Daftar
                                        </button>                                        
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <p class="mb-1" style="color:#333; font-size: 0.95rem;">
                                            Sudah punya akun?
                                            <a href="/login" 
                                            style="color:#D32F2F; font-weight:600; text-decoration:none;">
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

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #D32F2F, #B71C1C); /* gradasi kuning */
        }
        .btn-custom {
            background-color: #FFD700 !important; /* merah terang */
            border: none;
        }
        .btn-custom:hover {
            background-color: #FFEB3B !important;
        }
    </style>
    
</body>

</html>