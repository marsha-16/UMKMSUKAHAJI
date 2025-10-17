@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Katalog</title>

<div class="container py-4">
    <!-- Judul dan Tombol -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 text-center text-md-start gap-3">
        <h2 class="fw-bold text-dark mb-0">Kelola Katalog UMKM</h2>

        <!-- Tombol Tambah Produk -->
        <button class="btn btn-success btn-sm px-3 mt-2 mt-md-0" 
                data-bs-toggle="modal" data-bs-target="#createModal" 
                style="white-space: nowrap;">
            + Tambah Produk
        </button>
    </div>

    <!-- Pencarian di Atas Tabel -->
    <div class="mb-3 d-flex justify-content-start">
        <form action="{{ route('admin.katalog.index') }}" method="GET" 
              class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('search') }}" style="width: 200px;">
            <button class="btn btn-outline-warning btn-sm" type="submit" title="Cari">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('admin.katalog.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                <i class="fas fa-undo"></i>
            </a>
        </form>
    </div>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert custom-alert fade show shadow-sm" role="alert" id="successMessage">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Produk -->
    <div class="table-container shadow-sm rounded overflow-hidden">
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-theme text-center">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($katalogs as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + $katalogs->firstItem() - 1 }}</td>
                            <td class="text-center">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" class="rounded shadow-sm" width="70" height="70" style="object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/70x70" class="rounded shadow-sm">
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td class="fw-bold text-dark">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="min-width:200px;">{{ Str::limit($item->description, 80) }}</td>
                            <td style="min-width:150px;">{{ $item->address }}</td>
                            <td style="min-width:120px;">{{ $item->phone }}</td>
                            <td class="text-center" style="min-width:90px;">
                                <button 
                                    class="btn btn-warning btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $item->id }}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Edit Produk">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <button 
                                    class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $item->id }}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Hapus Produk">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.katalog.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-dark position-relative">
                                            <h5 class="modal-title fw-bold">Edit Produk</h5>
                                            <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label>Nama Produk</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Harga</label>
                                                    <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label>Deskripsi</label>
                                                    <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Alamat</label>
                                                    <input type="text" name="address" class="form-control" value="{{ $item->address }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>No. Telepon</label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $item->phone }}">
                                                </div>
                                                <div class="col-12">
                                                    <label>Gambar</label>
                                                    <input type="file" name="image" class="form-control">
                                                    @if($item->image)
                                                        <img src="{{ asset($item->image) }}" class="mt-2 rounded shadow-sm" width="100">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning text-dark">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.katalog.destroy',$item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header bg-danger text-white position-relative">
                                            <h5 class="modal-title fw-bold">Hapus Produk</h5>
                                            <button type="button" class="close-icon text-white" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus <b>{{ $item->name }}</b>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
    @if ($katalogs->lastPage() > 1)
        <div style="margin: 15px 10px 40px 10px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px;">
            
            {{-- Info jumlah data --}}
            <div style="font-size: 14px; color: #374151;">
                Menampilkan {{ $katalogs->firstItem() }} - {{ $katalogs->lastItem() }} dari {{ $katalogs->total() }} produk
            </div>

            {{-- Navigasi halaman --}}
            <div style="display: flex; flex-wrap: wrap; gap: 5px; justify-content: center;">
                {{-- Tombol Prev --}}
                @if ($katalogs->onFirstPage())
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                @else
                    <a href="{{ $katalogs->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                @endif

                {{-- Nomor halaman terbatas 3 --}}
                @php
                    $start = max($katalogs->currentPage() - 1, 1);
                    $end = min($katalogs->currentPage() + 1, $katalogs->lastPage());
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $katalogs->currentPage())
                        <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                    @else
                        <a href="{{ $katalogs->url($page) }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Tombol Next --}}
                @if ($katalogs->hasMorePages())
                    <a href="{{ $katalogs->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                @else
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                @endif
            </div>
        </div>
    @endif

<!-- Modal Tambah Produk -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white position-relative">
                    <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                    <button type="button" class="close-icon text-white" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Alamat</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>No. Telepon</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-12">
                            <label>Gambar Produk</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alert & Style tetap -->
<script>
setTimeout(() => {
    const alert = document.getElementById('successMessage');
    if (alert) {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);

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
    .custom-alert {
        background: linear-gradient(90deg, #FFC107, #FF7043, #F44336);
        color: #fff;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        padding: 12px 16px;
    }
    thead.table-theme {
        background: linear-gradient(90deg, #FFC107, #FF7043, #F44336);
        color: #fff;
    }
    .btn-success { background-color: #FF5722; border: none; }
    .btn-warning { background-color: #FFC107; border: none; color: #000; font-weight: 500; }
    .btn-danger { background-color: #F44336; border: none; }
    .close-icon {
        position: absolute;
        top: 10px;
        right: 15px;
        background: transparent;
        border: none;
        font-size: 1.8rem;
        font-weight: bold;
        color: inherit;
        cursor: pointer;
        line-height: 1;
    }
    /* Pastikan tabel bisa di-scroll dengan halus di HP */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Supaya tabel tidak menumpuk teks di kolom sempit */
.table td, 
.table th {
    white-space: nowrap;
    vertical-align: middle;
}

/* Sedikit jarak agar tabel enak di-scroll */
.table-container {
    margin-bottom: 1rem;
}

</style>
@endsection
