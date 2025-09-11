@extends('layouts.app')

@section('content')
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

        {{-- Flash Messages --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 d-flex justify-content-between align-items-center" role="alert">
            <span>{{ session('success') }}</span>
        </div>        
        @endif
    
        @if (session('error'))
        <div class="alert alert-success alert-dismissible fade show mt-3 d-flex justify-content-between align-items-center" role="alert">
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
                                    <td>{{ $item->report_date_label }}</td>
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
                <div class="card-footer">
                    {{ $pemetaans->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
