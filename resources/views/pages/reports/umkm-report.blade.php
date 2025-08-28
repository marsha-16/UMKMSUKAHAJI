@extends('layouts.app')

@section('content')
<div class="container report-container">

    <!-- Header laporan -->
    <div class="mb-4 report-header text-center">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo Kiri (Kelurahan) -->
            <img src="{{ asset('images/logo.sukahaji.png') }}" alt="Logo Kelurahan" style="height:70px;">

            <!-- Teks Judul -->
            <div class="flex-grow-1 text-center">
                <h3 class="mt-2 mb-1">KELURAHAN SUKAHAJI</h3>
                <p class="mb-0">Jl. H.Zakaria No. 24, Kelurahan Sukahaji, Kecamatan Babakan Ciparay, Kota Bandung, 40221</p>
            </div>

            <!-- Logo Kanan (UMKM) -->
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
    <table class="table table-bordered table-hover">
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
                <th>File Dokumen</th>
                <th>Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemetaans as $i => $item)
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
                    <td>
                        @if (!empty($item->photo_proof))
                            @php 
                                $filePath = 'storage/' . $item->photo_proof; 
                                $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                            @endphp
                    
                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset($filePath) }}" alt="File Dokumen" style="max-width: 120px; max-height: 120px;">
                            @elseif(strtolower($ext) === 'pdf')
                                <a href="{{ asset($filePath) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    📄 Lihat PDF
                                </a>
                            @else
                                <a href="{{ asset($filePath) }}" target="_blank">Unduh Dokumen</a>
                            @endif
                        @else
                            Tidak ada
                        @endif
                    </td>                    
                    <td>{{ $item->report_date_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
/* ===== Untuk layar biasa (responsive scroll) ===== */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* ===== Styling khusus cetak ===== */
@media print {
    /* Hilangkan elemen luar */
    .sidebar, 
    .navbar, 
    .no-print {
        display: none !important;
    }

    @media print {
    .no-print {
        display: none !important;
    }
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
        padding: 0  !important;
    }

    /* Header rapih */
    .report-header {
        text-align: center !important;
        margin-bottom: 15px !important;
    }
    .report-header h3 {
        font-size: 14pt !important;
        font-weight: bold !important;
        margin-bottom: 4px !important;
    }
    .report-header p {
        font-size: 9pt !important;
        margin: 0 !important;
    }

    /* Tabel full */
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
    /* Gambar dalam tabel */
    td img {
        max-width:60px !important;
        max-height: 60px !important;
        display: block !important;
        margin: auto !important;
    }

    /* Link jadi teks biasa */
    td a {
        text-decoration: none !important;
        color: black !important;
    }

    /* Header tabel muncul di tiap halaman */
    thead {
        display: table-header-group !important;
    }

    /* Hindari tabel terpotong aneh */
    tr, td, th {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Atur kertas */
    @page {
        size: A4 portrait;
        margin: 10mm 8mm 10mm 8mm;
    }

    /* Footer */
    .report-footer {
        text-align: center !important;
        margin-top: 15px !important;
        font-size: 8pt !important;
    }
}
</style>
@endsection
