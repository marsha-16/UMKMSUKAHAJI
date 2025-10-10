@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Tentang UMKM</title>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark font-weight-bold">Tentang UMKM Sukahaji</h2>
        <!-- Tombol Tambah Data -->
        <button class="btn btn-warning text-dark font-weight-bold" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus-circle"></i> Tambah Data
        </button>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-dark text-white">
                    <tr class="text-center">
                        <th style="width: 20%;">Judul</th>
                        <th style="width: 55%;">Deskripsi</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tentangs as $tentang)
                        <tr>
                            <td class="align-middle font-weight-bold">{{ $tentang->judul }}</td>
                            <td class="align-middle">{{ Str::limit($tentang->deskripsi, 80) }}</td>
                            <td class="text-center align-middle">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm text-white" style="background-color: orange;" data-toggle="modal" data-target="#editModal{{ $tentang->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $tentang->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $tentang->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $tentang->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tentang.update', $tentang->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header text-white" style="background-color: orange;">
                                            <h5 class="modal-title" id="editModalLabel{{ $tentang->id }}"><i class="fas fa-edit"></i> Edit Tentang UMKM</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="judul" value="{{ $tentang->judul }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="5" required>{{ $tentang->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn text-white" style="background-color: orange;">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Edit -->

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="deleteModal{{ $tentang->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tentang->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tentang.destroy', $tentang->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $tentang->id }}"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus <strong>{{ $tentang->judul }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Hapus -->
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.tentang.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="createModalLabel"><i class="fas fa-plus-circle"></i> Tambah Tentang UMKM</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
