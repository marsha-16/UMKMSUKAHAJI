@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 fw-bold text-dark">Dashboard</h1>
    </div>

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <!-- Logo -->
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Pemetaan UMKM Kelurahan Sukahaji" 
                         class="img-fluid mb-3 rounded-circle shadow-sm"
                         style="max-height:180px;">
                    
                    <h4 class="fw-bold mb-1">Selamat Datang, <strong>{{ auth()->user()->name }}</strong>! </h4>
                    <p class="text-muted"> Ayo kelola dan jelajahi UMKM Sukahaji dengan lebih mudah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row g-4">
        <!-- Tentang UMKM Sukahaji -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('tentang-umkm') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 h-100 text-center hover-card gradient-blue text-white">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <h5 class="fw-bold">Tentang UMKM Sukahaji</h5>
                        <p class="small">Pelajari informasi lengkap tentang UMKM Sukahaji</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pemetaan UMKM Sukahaji -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('pemetaan') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 h-100 text-center hover-card gradient-green text-white">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                        <h5 class="fw-bold">Pemetaan UMKM</h5>
                        <p class="small">Lihat persebaran UMKM di wilayah Sukahaji</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Katalog UMKM -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('katalog.index') }}" class="text-decoration-none">
                <div class="card shadow-lg border-0 h-100 text-center hover-card gradient-orange text-white">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-store fa-3x mb-3"></i>
                        <h5 class="fw-bold">Katalog UMKM</h5>
                        <p class="small">Jelajahi berbagai produk UMKM Sukahaji</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Hover effect */
    .hover-card {
        transition: all 0.3s ease-in-out;
        border-radius: 15px;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.2) !important;
    }

    /* Gradient background */
    .gradient-blue {
        background: linear-gradient(135deg, #1e88e5, #42a5f5);
    }
    .gradient-green {
        background: linear-gradient(135deg, #43a047, #66bb6a);
    }
    .gradient-orange {
        background: linear-gradient(135deg, #fb8c00, #ff7043);
    }

    /* Text color white */
    .hover-card h5,
    .hover-card p,
    .hover-card i {
        color: #fff !important;
    }

    /* Stats card */
    .stat-card {
        border-radius: 12px;
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.8rem 1.5rem rgba(0,0,0,0.15);
    }

    /* Responsive tweak */
    @media (max-width: 768px) {
        h1.h3 {
            font-size: 1.4rem;
        }
        .card-body p {
            font-size: 0.85rem;
        }
    }
</style>
@endpush
