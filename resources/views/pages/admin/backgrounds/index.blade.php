@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Masthead</title>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Kelola Background</h2>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus-circle me-1"></i> Tambah Foto
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead style="background: linear-gradient(90deg, #dc3545, #fd7e14, #ffc107); color: white;">
                        <tr>
                            <th style="width: 45px;">No</th>
                            <th style="width: 300px;">Gambar</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backgrounds as $index => $bg)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                <img src="{{ asset($bg->image) }}" 
                                    class="img-thumbnail rounded shadow-sm" 
                                    style="width:220px; height:120px; object-fit:cover;" 
                                    alt="bg-{{ $bg->id }}">
                            </td>
                            <td class="text-center" style="min-width:90px;">
                                <button 
                                    class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $bg->id }}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Edit Produk">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <button 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $bg->id }}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Hapus Produk">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted">Belum ada background yang diupload</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.backgrounds.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header d-flex justify-content-between align-items-center" style="background-color:#ffc107;">
                <h5 class="modal-title text-dark mb-0" id="addModalLabel">Tambah Background</h5>
                <button type="button" class="btn text-dark fs-4" data-bs-dismiss="modal" style="border:none; background:none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="https://via.placeholder.com/600x300?text=Preview" class="img-fluid mb-3 rounded shadow-sm" id="preview-add" style="max-height: 250px; object-fit: cover;">
                <input type="file" name="image" class="form-control" required onchange="previewImage(event, 'preview-add')">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Upload</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
@foreach($backgrounds as $bg)
<div class="modal fade" id="editModal{{ $bg->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bg->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.backgrounds.update', $bg->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header d-flex justify-content-between align-items-center" style="background-color:#fd7e14;">
                <h5 class="modal-title text-white mb-0" id="editModalLabel{{ $bg->id }}">Edit Background</h5>
                <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" style="border:none; background:none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset($bg->image) }}" class="img-fluid mb-3 rounded shadow-sm" id="preview-edit-{{ $bg->id }}" style="max-height: 250px; object-fit: cover;">
                <input type="file" name="image" class="form-control mt-2" onchange="previewImage(event, 'preview-edit-{{ $bg->id }}')">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal{{ $bg->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background-color:#dc3545;">
                <h5 class="modal-title text-white mb-0">Konfirmasi Hapus</h5>
                <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" style="border:none; background:none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Yakin ingin menghapus foto ini?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.backgrounds.destroy', $bg->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // === Preview Gambar ===
    function previewImage(event, previewId) {
        const input = event.target;
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById(previewId);
            if (img) img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }

    // === Popup Berhasil Tanpa Tombol dan Tanpa Garis Timer ===
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1800,
            timerProgressBar: false,
            position: 'center'
        });
    @endif

    // === Popup Gagal Tanpa Tombol dan Tanpa Garis Timer ===
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: false,
            position: 'center'
        });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi semua tooltip Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Auto-hide alert sukses
    setTimeout(() => {
        const alert = document.getElementById('successMessage');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
});
</script>
<style>
    /* Pastikan tabel bisa digeser di layar kecil */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Supaya semua kolom tetap sejajar dan tidak memecah teks */
.table th,
.table td {
    white-space: nowrap;
    vertical-align: middle;
}

/* Biar tabel tidak kepotong di container */
.card-body {
    overflow-x: auto;
}

/* Untuk menjaga jarak dan tampilan rapi */
.table img {
    max-width: 100%;
    height: auto;
}

</style>
@endpush
