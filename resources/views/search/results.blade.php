@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Pencarian</title>

<div class="container">

    <!-- Hasil Pencarian -->
    @isset($keyword)
        <div class="mb-4 text-center">
            <h5 class="fw-bold">Hasil Pencarian: <span class="text-primary">{{ $keyword }}</span></h5>
        </div>
    @endisset

    <!-- USERS -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #fbbf24, #f97316, #dc2626, #111827);">
            <h5 class="mb-0 fw-bold">Data Users</h5>
        </div>
        <div class="card-body">
            @if(isset($users) && $users->isEmpty())
                <div class="alert alert-warning mb-0">Tidak ada user ditemukan.</div>
            @elseif(isset($users))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @switch($user->status)
                                        @case('submitted')
                                            <span class="badge bg-warning text-dark">Submitted</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success text-white">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger text-white">Rejected</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary text-white">Unknown</span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- PEMETAAN -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #fbbf24, #f97316, #dc2626, #111827);">
            <h5 class="mb-0 fw-bold">Data Pemetaan UMKM</h5>
        </div>
        <div class="card-body">
            @if(isset($pemetaans) && $pemetaans->isEmpty())
                <div class="alert alert-warning mb-0">Tidak ada data UMKM ditemukan.</div>
            @elseif(isset($pemetaans))
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIK</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemetaans as $pemetaan)
                            <tr>
                                <td>{{ $pemetaan->name }}</td>
                                <td>{{ $pemetaan->nik }}</td>
                                <td>{{ $pemetaan->address }}</td>
                                <td class="text-center">
                                    @switch($pemetaan->status)
                                        @case('process')
                                            <span class="badge bg-info text-white">Process</span>
                                            @break
                                        @case('approve')
                                            <span class="badge bg-success text-white">Approve</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger text-white">Rejected</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary text-white">Unknown</span>
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

<style>
    th {
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.9rem;
    }
</style>
@endsection
