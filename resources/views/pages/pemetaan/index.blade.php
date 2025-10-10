@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Pemetaan</title>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ auth('admin')->check() ? 'Data Pemetaan' : 'Pemetaan UMKM' }}
        </h1>
        
        <div class="d-flex align-items-center" style="gap: 10px;">
            {{-- Tombol Cetak Laporan (Admin Only) --}}
            @if(auth('admin')->check())
                <a href="{{ route('reports.umkm') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-file-pdf fa-sm text-white-50"></i> Laporan 
                </a>
            @endif
            
            {{-- Tombol Buat Pemetaan (hanya untuk User) --}}
            @auth
            @if(auth('web')->check())
                <a href="/pemetaan/create" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pemetaan UMKM
                </a>
            @endif
            @endauth

        </div>
    </div>
    <div class="container">

        {{-- Flash Messages dengan SweetAlert2 --}}
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK',
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'Tutup',
                    });
                });
            </script>
        @endif
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if (auth('admin')->check())
                                    <th>Nama Penduduk</th>
                                @endif
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Jenis Usaha</th>
                                <th>Jenis Pemasaran</th>
                                <th>Platform Digital</th>
                                <th>Dokumen Penunjang</th>
                                <th>Foto Dokumen</th>
                                <th>Tanggal Laporan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @if (count($pemetaans) < 1)
                        <tbody>
                            <tr>
                                <td colspan="10">
                                    <p class="pt-3 text-center">Tidak Ada Data</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($pemetaans as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $pemetaans->firstItem() -1 }}</td>
                                    @if (auth('admin')->check())
                                        <td>{{ $item->umkm->name }}</td>
                                    @endif
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->business }}</td>
                                    <td>{{ $item->marketing }}</td>
                                    <td>{{ $item->promotion }}</td>
                                    <td>{{ $item->document }}</td>
                                    <td class="text-center align-middle">
                                        @php
                                            $photo = $item->document_photo;
                                        @endphp

                                        @if (empty($photo) || $photo === 'images/default.png' || !file_exists(public_path($photo)))
                                            <span class="text-muted fst-italic">Tidak ada</span>
                                        @else
                                            @php
                                                $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
                                                $fileName = basename($photo);
                                            @endphp

                                            @if (in_array($extension, ['jpg','jpeg','png','gif','webp']))
                                                <!-- Kalau gambar -->
                                                <a href="{{ asset($photo) }}" target="_blank" title="{{ $fileName }}">
                                                    <img src="{{ asset($photo) }}" 
                                                        alt="Foto Dokumen" 
                                                        class="img-thumbnail" 
                                                        style="max-width: 120px;">
                                                </a>
                                            @elseif ($extension === 'pdf')
                                                <!-- Kalau PDF -->
                                                <a href="{{ asset($photo) }}" target="_blank" title="{{ $fileName }}">
                                                    <i class="fa-solid fa-file-pdf fa-3x text-danger"></i>
                                                </a>
                                            @elseif (in_array($extension, ['doc','docx']))
                                                <!-- Kalau Word -->
                                                <a href="{{ asset($photo) }}" target="_blank" title="{{ $fileName }}">
                                                    <i class="fa-solid fa-file-word fa-3x text-primary"></i>
                                                </a>
                                            @elseif (in_array($extension, ['xls','xlsx']))
                                                <!-- Kalau Excel -->
                                                <a href="{{ asset($photo) }}" target="_blank" title="{{ $fileName }}">
                                                    <i class="fa-solid fa-file-excel fa-3x text-success"></i>
                                                </a>
                                            @else
                                                <!-- File lain -->
                                                <a href="{{ asset($photo) }}" target="_blank" title="{{ $fileName }}">
                                                    <i class="fa-solid fa-file fa-3x text-secondary"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td data-report-date="{{ \Carbon\Carbon::parse($item->report_date)->toIso8601String() }}">
                                        {{ $item->report_date_label }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $item->status_color }}">{{ $item->status_label }}</span>
                                    </td>
                                    <td>
                                        @if (auth('web')->check() && isset(auth('web')->user()->umkm) && $item->status == 'process')
                                            <!-- USER BIASA: Edit & Hapus -->
                                            <div class="d-flex align-items-center" style="gap: 10px;">
                                                <a href="/pemetaan/{{ $item->id }}" class="d-inline-block btn btn-sm btn-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                    <i class="fas fa-eraser"></i>
                                                </button>
                                            </div>
                                        @elseif (auth('admin')->check())
                                            <!-- ADMIN: Update Status -->
                                            <form id="formChangeStatus-{{ $item->id }}" action="/pemetaan/update-status/{{ $item->id }}" method="post" style="min-width: 150px;">
                                                @csrf
                                                @method('POST')
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    @foreach ([
                                                        (object)['label' => 'Sedang Diproses', 'value' => 'process'],
                                                        (object)['label' => 'Diterima', 'value' => 'approve'],
                                                        (object)['label' => 'Ditolak', 'value' => 'rejected']
                                                    ] as $status)
                                                        <option value="{{ $status->value }}" @selected($item->status == $status->value)>{{ $status->label }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </td>                                    
                                </tr>
                                @include('pages.pemetaan.confirmation-delete')
                            @endforeach
                        </tbody>
                    @endif
                    </table>
                </div>
                @if ($pemetaans->lastPage() > 1)
                    <div style="margin: 10px 20px 40px 20px; display: flex; justify-content: space-between; align-items: center;">
                        
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
            </div>
        </div>
    </div>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const { DateTime } = luxon;

    document.querySelectorAll("[data-report-date]").forEach(td => {
        const rawDate = td.getAttribute("data-report-date");

        // Konversi UTC → Asia/Jakarta
        const formatted = DateTime.fromISO(rawDate, { zone: "utc" })
            .setZone("Asia/Jakarta")
            .toFormat("dd LLLL yyyy HH:mm:ss");

        td.textContent = formatted;
    });
});
</script>
@endsection
