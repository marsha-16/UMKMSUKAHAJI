@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Data Penduduk</title>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
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

{{-- Table Section --}}
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">

                {{-- 🔍 Search Bar --}}
                <form action="{{ url('/umkm') }}" method="GET" class="mb-3 d-flex justify-content-end align-items-center flex-wrap" style="gap: 10px;">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="form-control form-control-sm" 
                        placeholder="Cari nama atau alamat..."
                        style="max-width: 250px;"
                    >
                    <button type="submit" class="btn btn-sm btn-warning shadow-sm text-white">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ url('/umkm') }}" class="btn btn-sm btn-secondary">Reset</a>
                    @endif
                </form>

                <table class="table table-bordered table-hovered" style="min-width: 100%">
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

            {{-- Pagination --}}
            @if ($umkms->lastPage() > 1)
                <div style="margin: 10px 20px 40px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    
                    {{-- Info jumlah data --}}
                    <div style="font-size: 14px; color: #374151;">
                        Menampilkan {{ $umkms->firstItem() }} - {{ $umkms->lastItem() }} dari {{ $umkms->total() }} data
                    </div>

                    {{-- Pagination --}}
                    <div style="display: flex; gap: 5px;">
                        {{-- Tombol Prev --}}
                        @if ($umkms->onFirstPage())
                            <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                        @else
                            <a href="{{ $umkms->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') }}" 
                               style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                        @endif

                        {{-- Nomor halaman terbatas 3 --}}
                        @php
                            $start = max($umkms->currentPage() - 1, 1);
                            $end = min($umkms->currentPage() + 1, $umkms->lastPage());
                        @endphp

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $umkms->currentPage())
                                <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                            @else
                                <a href="{{ $umkms->url($page) . (request('search') ? '&search=' . request('search') : '') }}" 
                                   style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Tombol Next --}}
                        @if ($umkms->hasMorePages())
                            <a href="{{ $umkms->nextPageUrl() . (request('search') ? '&search=' . request('search') : '') }}" 
                               style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                        @else
                            <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
