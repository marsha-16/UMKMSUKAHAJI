@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Profile</title>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Profil</h1>
</div>

@if (session('success'))
    <script>
        Swal.fire({
            title: "Berhasil",
            text: "{{ session('success') }}",
            icon: "success",
        });
    </script>
@endif

<div class="d-flex justify-content-center">
    <div class="col">
        <form action="/profile/{{ $user->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card shadow">
                <div class="card-body">
                    <!-- Foto Profil -->
                    <div class="form-group mb-4 text-center">
                        <label for="photo" class="d-block mb-2 font-weight-bold">Foto Profil</label>
                        @if ($user->photo)
                            <img src="{{ asset($user->photo) }}" alt="Foto Profil"
                                class="rounded mb-2 shadow-sm border" width="120" height="120">

                            <div class="mt-2 d-flex justify-content-center gap-2">
                                <input type="file" name="photo" id="photo"
                                    class="form-control-file @error('photo') is-invalid @enderror">

                                <!-- Tombol Hapus Foto -->
                                <form action="{{ route('profile.deletePhoto', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus foto profil ini?')">
                                        Hapus Foto
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="d-flex justify-content-center align-items-center bg-light rounded-circle border shadow-sm mb-2 mx-auto"
                                style="width:120px; height:120px;">
                                <i class="fas fa-user text-secondary" style="font-size:50px;"></i>
                            </div>
                            <input type="file" name="photo" id="photo"
                                class="form-control-file mt-2 @error('photo') is-invalid @enderror">
                        @endif
                        @error('photo')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

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
                            <a href="/dashboardAdmin" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        @elseif(Auth::guard('web')->check())
                            <a href="/dashboard" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @push('scripts')
        <script>
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
        </script>
        @endpush
    </div>
</div>
@endsection
