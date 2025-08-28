@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">🔍 Hasil Pencarian: <span class="text-primary">{{ $keyword }}</span></h3>

    {{-- USERS --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">👤 Users</h5>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <div class="alert alert-warning">Tidak ada user ditemukan.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
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

    {{-- PEMETAAN --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">🏬 Pemetaan UMKM</h5>
        </div>
        <div class="card-body">
            @if($pemetaans->isEmpty())
                <div class="alert alert-warning">Tidak ada data UMKM ditemukan.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemetaans as $pemetaan)
                            <tr>
                                <td>{{ $pemetaan->nik }}</td>
                                <td><strong>{{ $pemetaan->name }}</strong></td>
                                <td>{{ $pemetaan->address }}</td>
                                <td>
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
@endsection
