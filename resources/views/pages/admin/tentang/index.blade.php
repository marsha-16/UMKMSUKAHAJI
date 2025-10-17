@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Tentang UMKM</title>

<div class="container-fluid px-3 px-md-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <h4 class="text-dark fw-bold mb-3 mb-md-0">Tentang UMKM Sukahaji</h4>

        <!-- Tombol Tambah -->
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-sm btn-warning text-dark fw-bold mb-2 mb-md-0" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </button>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow border-0">
        <div class="card-body table-responsive p-2">
            <table class="table table-sm table-bordered table-striped align-middle text-sm">
                <thead class="bg-dark text-white text-center">
                    <tr>
                        <th style="width: 15%;">Judul</th>
                        <th style="width: 60%;">Deskripsi</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tentangs as $tentang)
                        <tr>
                            <td class="fw-bold text-center small">{{ $tentang->judul }}</td>
                            <td class="small" style="word-break: break-word;">
                                {!! preg_replace(
                                    '/(https?:\/\/[^\s]+)/',
                                    '<a href="$1" target="_blank" style="color:#f97316; font-weight:bold;">$1</a>',
                                    e(Str::limit($tentang->deskripsi, 120))
                                ) !!}
                            </td>
                            <td class="text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-xs text-white" style="background-color: orange;" 
                                        data-toggle="modal" data-target="#editModal{{ $tentang->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn btn-xs btn-danger" 
                                        data-toggle="modal" data-target="#deleteModal{{ $tentang->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $tentang->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $tentang->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tentang.update', $tentang->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header text-white" style="background-color: orange;">
                                            <h6 class="modal-title"><i class="fas fa-edit"></i> Edit Tentang UMKM</h6>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-3">
                                            <div class="form-group mb-2">
                                                <label class="small">Judul</label>
                                                <input type="text" name="judul" value="{{ $tentang->judul }}" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label class="small">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control form-control-sm" rows="4" required>{{ $tentang->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer py-2">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-sm text-white" style="background-color: orange;">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="deleteModal{{ $tentang->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tentang->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tentang.destroy', $tentang->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="modal-header bg-danger text-white py-2">
                                            <h6 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Hapus Data</h6>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body small">
                                            Apakah kamu yakin ingin menghapus <strong>{{ $tentang->judul }}</strong>?
                                        </div>
                                        <div class="modal-footer py-2">
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted small">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.tentang.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark py-2">
                    <h6 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Tentang UMKM</h6>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group mb-2">
                        <label class="small">Judul</label>
                        <input type="text" name="judul" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group mb-2">
                        <label class="small">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control form-control-sm" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
@endpush

@push('styles')
<style>
.table th, .table td {
    padding: 6px 8px;
    font-size: 13px;
}
.table th {
    font-size: 13px;
    text-transform: uppercase;
}
.modal-content {
    border-radius: 10px;
}
.btn-xs {
    padding: 3px 7px;
    font-size: 12px;
}
@media (max-width: 768px) {
    h4 { font-size: 1.1rem; }
    .table th, .table td { font-size: 12px; }
    .modal-lg { max-width: 95%; }
}
</style>
@endpush
