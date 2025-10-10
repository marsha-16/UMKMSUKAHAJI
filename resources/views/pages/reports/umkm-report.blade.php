@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Laporan UMKM</title>

<div class="container report-container">

    <!-- Header laporan -->
    <div class="mb-4 report-header text-center">
        <div class="d-flex justify-content-between align-items-center">
            <img src="{{ asset('images/logo.sukahaji.png') }}" alt="Logo Kelurahan" style="height:70px;">
            <div class="flex-grow-1 text-center">
                <h2 class="mt-2 mb-1">KELURAHAN SUKAHAJI</h2>
                <p class="mb-0">Jalan H. Zakaria No. 24 Kota Bandung, 40221</p>
                <p class="mb-0">Telp. (022) 6026078</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo UMKM" style="height:100px;">
        </div>
        <hr style="border: 1px solid #000;">
    </div>

    <h5 class="mb-3 text-center">Laporan Data UMKM</h5>

    <!-- Tombol cetak PDF -->
    <div class="d-flex justify-content-end gap-2 no-print mb-3">
        <a href="/pemetaan" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </button>
    </div>

    <div class="table-container">

        {{-- Tabel web (paginate) --}}
        <table class="table table-bordered table-hover no-print">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Jenis Usaha</th>
                    <th>Yang Lain</th>
                    <th>Jenis Pemasaran</th>
                    <th>Platform Digital</th>
                    <th>Dokumen Penunjang</th>
                    <th>Tanggal Input</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemetaans as $i => $item)
                    <tr>
                        <td>{{ $i + 1 + ($pemetaans->currentPage() - 1) * $pemetaans->perPage() }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->business }}</td>
                        <td>{{ $item->other }}</td>
                        <td>{{ $item->marketing }}</td>
                        <td>{{ $item->promotion }}</td>
                        <td>{{ $item->document }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        {{-- <td>{{ $item->status_label ?? ucfirst($item->status) }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($pemetaans->lastPage() > 1)
            <div class="no-print" style="margin: 10px 20px 40px 20px; display: flex; justify-content: space-between; align-items: center;">
                        
                {{-- Info jumlah data --}}
                <div style="font-size: 14px; color: #374151;">
                    Menampilkan {{ $pemetaans->firstItem() }} - {{ $pemetaans->lastItem() }} dari {{ $pemetaans->total() }} data
                </div>

                {{-- Pagination --}}
                <div style="display: flex; gap: 5px;">
                    {{-- Tombol Prev --}}
                    @if ($pemetaans->onFirstPage())
                        <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                    @else
                        <a href="{{ $pemetaans->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                    @endif

                    {{-- Nomor halaman terbatas 3 --}}
                    @php
                        $start = max($pemetaans->currentPage() - 1, 1);
                        $end = min($pemetaans->currentPage() + 1, $pemetaans->lastPage());
                    @endphp

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $pemetaans->currentPage())
                            <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                        @else
                            <a href="{{ $pemetaans->url($page) }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Tombol Next --}}
                    @if ($pemetaans->hasMorePages())
                        <a href="{{ $pemetaans->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                    @else
                        <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                    @endif
                </div>
            </div>
        @endif

        {{-- Tabel print (all data) --}}
        <table class="table table-bordered table-hover print-only" style="display:none;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Jenis Usaha</th>
                    <th>Jenis Pemasaran</th>
                    <th>Platform Digital</th>
                    <th>Dokumen Penunjang</th>
                    <th>Tanggal Input</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemetaansAll as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->business }}</td>
                        <td>{{ $item->marketing }}</td>
                        <td>{{ $item->promotion }}</td>
                        <td>{{ $item->document }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->status_label ?? ucfirst($item->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<style>
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* Print styling */
@media print {
    .no-print,
    .sidebar,
    .main-sidebar,
    .navbar,
    .topbar,
    .footer,
    .btn,
    .pagination {
        display: none !important;
    }

    .print-only {
        display: table !important;
    }

    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
        zoom: 70%;
    }

    .report-container {
        width: 100% !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: auto !important;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 3px 2px !important;
        font-size: 8.5pt !important;
        text-align: center !important;
        vertical-align: middle !important;
        word-wrap: break-word !important;
    }

    thead { display: table-header-group !important; }
    tr, td, th { page-break-inside: avoid !important; break-inside: avoid !important; }

    @page { size: A4 portrait; margin: 10mm 8mm 10mm 8mm; }
}
</style>
@endsection
