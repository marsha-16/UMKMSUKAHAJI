@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Ubah Password</title>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Password</h1>
</div>

<div class="row">
    <div class="col">
        <form 
            action="{{ Auth::guard('admin')->check() 
                ? url('/change-password/' . Auth::guard('admin')->user()->id) 
                : url('/change-password/' . Auth::guard('web')->user()->id) }}" 
            method="POST">
            @csrf
            @method('POST')

            <div class="card">
                <div class="card-body">
                    <!-- Password Lama -->
                    <div class="form-group mb-3">
                        <label for="old_password">Password Lama</label>
                        <input type="password" name="old_password" id="old_password"
                            class="form-control @error('old_password') is-invalid @enderror">
                        @error('old_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group mb-3">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" id="new_password"
                            class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-3">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control @error('new_password_confirmation') is-invalid @enderror">
                        @error('new_password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end" style="gap: 10px;">
                        @if(Auth::guard('admin')->check())
                            <a href="/dashboardAdmin" class="btn btn-outline-secondary">Kembali</a>
                        @elseif(Auth::guard('web')->check())
                            <a href="/dashboard" class="btn btn-outline-secondary">Kembali</a>
                        @endif
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// === Tampilkan popup sukses/gagal setelah halaman selesai dimuat ===
document.addEventListener("DOMContentLoaded", function() {
    @if (session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            @if(Auth::guard('admin')->check())
                window.location.href = "/dashboardAdmin";
            @elseif(Auth::guard('web')->check())
                window.location.href = "/dashboard";
            @endif
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: "OK"
        });
    @endif
});
</script>
@endpush
