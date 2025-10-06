@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Judul -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold text-dark">Kelola Katalog UMKM</h2>
        <!-- Tombol tambah produk -->
        <button class="btn btn-success mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Produk
        </button>
    </div>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert custom-alert fade show shadow-sm" role="alert" id="successMessage">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Produk -->
    <div class="table-responsive shadow rounded">
        <table class="table table-hover align-middle">
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
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if($item->image)
                                <img src="{{ asset($item->image) }}" class="rounded shadow-sm" width="80" height="80" style="object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/80x80" class="rounded shadow-sm">
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td class="fw-bold text-success">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">Hapus</button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.katalog.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama Produk</label>
                                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Deskripsi</label>
                                            <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Alamat</label>
                                            <input type="text" name="address" class="form-control" value="{{ $item->address }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>No. Telepon</label>
                                            <input type="text" name="phone" class="form-control" value="{{ $item->phone }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Gambar</label><br>
                                            <input type="file" name="image" class="form-control">
                                            @if($item->image)
                                                <img src="{{ asset($item->image) }}" class="mt-2 rounded" width="100">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.katalog.destroy',$item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Hapus Produk</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <td colspan="8" class="text-center">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
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

<!-- Auto hide pesan sukses -->
<script>
    setTimeout(() => {
        let alert = document.getElementById('successMessage');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

<!-- Custom Style -->
<style>
    /* Warna alert sesuai tema */
    .custom-alert {
        background: linear-gradient(90deg, #FFC107, #FF7043, #F44336);
        color: #fff;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        padding: 12px 16px;
    }

    /* Header tabel dengan gradasi senada logo */
    thead.table-theme {
        background: linear-gradient(90deg, #FFC107, #FF7043, #F44336);
        color: #fff;
    }
    thead.table-theme th {
        border: none;
    }

    /* Baris tabel */
    .table tbody tr:nth-child(even) {
        background-color: #fff8e1; /* kuning muda */
    }
    .table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    .table tbody tr:hover {
        background-color: #ffe0b2; /* oranye muda */
        transition: 0.3s;
    }

    /* Tombol senada dengan logo */
    .btn-warning {
        background-color: #FFC107;
        border: none;
        color: #000;
        font-weight: 500;
    }
    .btn-danger {
        background-color: #F44336;
        border: none;
    }
    .btn-success {
        background-color: #FF5722;
        border: none;
    }

    /* Responsive */
    @media (max-width: 576px) {
        h2.fw-bold {
            font-size: 1.5rem;
            text-align: center;
        }
        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
