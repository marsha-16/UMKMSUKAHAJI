@extends('layouts.app')

@section('content')
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
                                    class="rounded mb-2" width="120" height="120">
                                    <input type="file" name="photo" id="photo"
                                        class="form-control-file mt-2 @error('photo') is-invalid @enderror">
                            @else
                                <img src="{{ asset('images/default.png') }}" alt="Default Foto"
                                    class="rounded mb-2" width="120" height="120">
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

                    <div class="card-footer d-flex justify-content-end">
                        <a href="/dashboard" class="btn btn-secondary mr-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
