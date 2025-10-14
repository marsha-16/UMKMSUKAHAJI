@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Profile</title>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Profil</h1>
</div>

<div class="d-flex justify-content-center">
    <div class="col">
        <form id="profileForm" action="/profile/{{ $user->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card shadow">
                <div class="card-body">
                    <!-- Foto Profil -->
                    <div class="form-group mb-3 text-center">
                        <div class="position-relative d-inline-block" style="cursor: pointer;">
                            <label for="photo" class="m-0">
                                <img id="previewPhoto"
                                    src="{{ $user->photo && file_exists(public_path($user->photo)) 
                                        ? asset($user->photo) 
                                        : asset('uploads/default.jpg') }}"
                                    alt="Foto Profil" class="rounded-circle mb-2"
                                    width="120" height="120" style="object-fit: cover;">
                                <div class="position-absolute bg-primary rounded-circle p-2"
                                    style="bottom: 5px; right: 5px;">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                            </label>
                        </div>

                        <div>
                            <label for="photo">Foto Profil</label>
                        </div>
                        <input type="file" id="photo" name="photo"
                            class="d-none @error('photo') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(event)">
                            
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <script>
                    function previewImage(event) {
                        const reader = new FileReader();
                        reader.onload = function(){
                            document.getElementById('previewPhoto').src = reader.result;
                        }
                        reader.readAsDataURL(event.target.files[0]);
                    }
                    </script>

                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" readonly>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end" style="gap: 10px;">
                        @if(Auth::guard('admin')->check())
                            <a href="#" id="btnCancelAdmin" class="btn btn-outline-secondary">Batal</a>
                        @elseif(Auth::guard('web')->check())
                            <a href="#" id="btnCancelUser" class="btn btn-outline-secondary">Batal</a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


{{-- =============================== --}}
{{-- ✅ Semua script di bawah --}}
{{-- =============================== --}}
@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ✅ Popup jika berhasil disimpan --}}
@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: "Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "OK"
    }).then((result) => {
        if (result.isConfirmed) {
            @if(Auth::guard('admin')->check())
                window.location.href = "/dashboardAdmin";
            @elseif(Auth::guard('web')->check())
                window.location.href = "/dashboard";
            @endif
        }
    });
});
</script>
@endif

<script>
// Preview foto
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.querySelector('.form-group img');
            if (img) img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Popup konfirmasi ketika menekan tombol batal
document.getElementById('btnCancelAdmin')?.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Batalkan perubahan?',
        text: "Perubahan yang belum disimpan akan hilang.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/dashboardAdmin";
        }
    });
});

document.getElementById('btnCancelUser')?.addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Batalkan perubahan?',
        text: "Perubahan yang belum disimpan akan hilang.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/dashboard";
        }
    });
});
</script>
@endpush
