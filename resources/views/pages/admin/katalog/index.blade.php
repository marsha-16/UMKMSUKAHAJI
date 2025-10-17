@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Katalog</title>

<div class="container py-4">
    <!-- Judul dan Tombol + Pencarian -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 text-center text-md-start">
        <h2 class="fw-bold text-dark mb-3 mb-md-0">Kelola Katalog UMKM</h2>

        <div class="d-flex flex-column flex-md-row align-items-md-center" style="gap: 15px;">
            <!-- Form Pencarian -->
            <form action="{{ route('admin.katalog.index') }}" method="GET" class="d-flex align-items-center" style="max-width: 300px;">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control form-control-sm me-2" 
                    placeholder="Cari produk..." 
                    value="{{ request('search') }}"
                >
                <button class="btn btn-outline-warning btn-sm me-2" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <!-- Tombol Reset -->
                <a href="{{ route('admin.katalog.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-undo"></i>
                </a>
            </form>

            <!-- Tombol Tambah Produk -->
            <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#createModal">
                + Tambah Produk
            </button>
        </div>
    </div>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert custom-alert fade show shadow-sm" role="alert" id="successMessage">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Produk -->
    <div class="table-responsive shadow-sm rounded overflow-hidden">
        <table class="table table-hover align-middle mb-0">
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
                                <img src="{{ asset($item->image) }}" class="rounded shadow-sm" width="80" height="80" style="object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/80x80" class="rounded shadow-sm">
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td class="fw-bold text-dark">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm mb-1 w-100" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">Hapus</button>
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

<!-- Info jumlah -->
<div class="text-center text-muted small mb-3">
    Menampilkan {{ $katalogs->firstItem() }} - {{ $katalogs->lastItem() }} dari total {{ $katalogs->total() }} produk
</div>

<!-- Pagination -->
<div class="d-flex justify-content-end align-items-center mt-3">
    <div style="display: flex; gap: 5px;">
        @if ($katalogs->onFirstPage())
            <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
        @else
            <a href="{{ $katalogs->previousPageUrl() }}&search={{ request('search') }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
        @endif

        @php
            $start = max($katalogs->currentPage() - 1, 1);
            $end = min($katalogs->currentPage() + 1, $katalogs->lastPage());
        @endphp

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $katalogs->currentPage())
                <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
            @else
                <a href="{{ $katalogs->url($page) }}&search={{ request('search') }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
            @endif
        @endfor

        @if ($katalogs->hasMorePages())
            <a href="{{ $katalogs->nextPageUrl() }}&search={{ request('search') }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
        @else
            <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
        @endif
    </div>
</div>

<!-- Auto hide alert -->
<script>
setTimeout(() => {
    const alert = document.getElementById('successMessage');
    if (alert) {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);
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
    thead.table-theme th {
        border: none;
    }

    .table tbody tr:nth-child(even) { background-color: #fff8e1; }
    .table tbody tr:nth-child(odd) { background-color: #ffffff; }
    .table tbody tr:hover { background-color: #ffe0b2; transition: 0.3s; }

    .btn-warning { background-color: #FFC107; border: none; color: #000; font-weight: 500; }
    .btn-danger { background-color: #F44336; border: none; }
    .btn-success { background-color: #FF5722; border: none; }

    @media (max-width: 768px) {
        h2.fw-bold { font-size: 1.4rem; text-align: center; }
        .btn { width: 100%; }
        table { font-size: 0.9rem; }
        .table-responsive { border-radius: 10px; }
        td img { width: 60px; height: 60px; }
        form.d-flex { width: 100%; }
    }

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
        transition: 0.2s;
    }
    .close-icon:hover { transform: scale(1.1); opacity: 0.8; }

    .bg-warning .close-icon { color: #000; }
    .bg-danger .close-icon { color: #fff; }
    .bg-success .close-icon { color: #fff; }
</style>
@endsection
