@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data UMKM Sukahaji</h1>
        <a href="/umkm/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </a>
    </div>

{{-- Flash Messages --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3 d-flex justify-content-between align-items-center" role="alert">
    <span>{{ session('success') }}</span>
</div>        
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3 d-flex justify-content-between align-items-center" role="alert">
    <span>{{ session('error') }}</span>
</div>        
@endif

{{-- Auto close after 3s --}}
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach((alert) => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>


    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered table-hovered " style="min-width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @if (count($umkms) < 1)
                        <tbody>
                            <tr>
                                <td colspan="10">
                                    <p class="pt-3 text-center">Tidak Ada Data</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($umkms as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $umkms->firstItem() -1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        <div class="d-flex align-items-center" style="gap: 10px;">
                                            <a href="/umkm/{{ $item->id }}" class="d-inline-block btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                <i class="fas fa-eraser"></i>
                                            </button>
                                            @if (!is_null($item->user_id))
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailAccount-{{ $item->id }}">
                                                    Lihat Akun
                                                </button>
                                                @include('pages.umkm.detail-account')  
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @include('pages.umkm.confirmation-delete')
                            @endforeach
                        </tbody>
                    @endif
                    </table>
                </div>
                @if ($umkms->lastPage() > 1)
                <div class="card-footer">
                    {{ $umkms->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
