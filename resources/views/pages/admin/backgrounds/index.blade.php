@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Kelola Background</h2>

    <!-- Button trigger modal tambah -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Tambah Foto
    </button>

    <!-- Tabel -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 200px;">Image</th>
                    <th style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backgrounds as $index => $bg)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>
                        <img src="{{ asset($bg->image) }}" class="img-thumbnail" width="180" alt="bg-{{ $bg->id }}">
                    </td>
                    <td>
                        <!-- Tombol Edit (type button agar tidak submit form lain) -->
                        <button type="button" class="btn btn-warning btn-sm mb-1"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $bg->id }}">
                            ✏️ Edit
                        </button>

                        <!-- Tombol Delete -->
                        <form action="{{ route('admin.backgrounds.destroy', $bg->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus foto ini?')">
                                🗑️ Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Belum ada background yang diupload</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (boleh tetap di sini) -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.backgrounds.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Background</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="https://via.placeholder.com/300x150?text=Preview" class="img-fluid mb-3 rounded" id="preview-add">
                <input type="file" name="image" class="form-control" required onchange="previewImage(event, 'preview-add')">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>

<!-- --- Semua Modal Edit dipanggil DI LUAR tabel agar tidak bentrok --- -->
@foreach($backgrounds as $bg)
<div class="modal fade" id="editModal{{ $bg->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bg->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.backgrounds.update', $bg->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $bg->id }}">Edit Background</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset($bg->image) }}" class="img-fluid mb-3 rounded" id="preview-edit-{{ $bg->id }}">
                <input type="file" name="image" class="form-control" onchange="previewImage(event, 'preview-edit-{{ $bg->id }}')">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    // preview image function
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
</script>
@endpush
