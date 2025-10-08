@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 fw-bold text-dark text-md-start w-100">Dashboard</h1>
    </div>

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <!-- Logo -->
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Pemetaan UMKM Kelurahan Sukahaji" 
                         class="img-fluid mb-3 rounded-circle shadow-sm"
                         style="max-height:160px; width:auto;">
                    
                    <h4 class="fw-bold mb-1 text-dark">
                        Selamat Datang, <strong>{{ auth()->user()->name }}</strong>!
                    </h4>
                    <p class="text-muted mb-0">
                        Ayo kelola dan jelajahi UMKM Sukahaji dengan lebih mudah.
                    </p>
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
    /* Card hover & radius */
    .hover-card {
        transition: all 0.3s ease-in-out;
        border-radius: 16px;
    }
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Gradients */
    .gradient-blue {
        background: linear-gradient(135deg, #1e88e5, #42a5f5);
    }
    .gradient-green {
        background: linear-gradient(135deg, #43a047, #66bb6a);
    }
    .gradient-orange {
        background: linear-gradient(135deg, #fb8c00, #ff7043);
    }

    /* Text */
    .hover-card h5,
    .hover-card p,
    .hover-card i {
        color: #fff !important;
    }

    /* Responsif */
    @media (max-width: 992px) {
        h1.h3 {
            font-size: 1.6rem;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .hover-card {
            border-radius: 12px;
        }
        .hover-card i {
            font-size: 2.3rem;
        }
        .hover-card h5 {
            font-size: 1rem;
        }
        .hover-card p {
            font-size: 0.85rem;
        }
        .card-body {
            padding: 1.2rem;
        }
        img {
            max-height: 130px !important;
        }
    }

    @media (max-width: 576px) {
        .hover-card {
            margin-bottom: 1rem;
        }
        .hover-card i {
            font-size: 2rem;
        }
        .hover-card h5 {
            font-size: 0.95rem;
        }
        .hover-card p {
            font-size: 0.8rem;
        }
        h1.h3 {
            font-size: 1.3rem;
        }
        .container {
            padding: 0 10px;
        }
    }
</style>
@endpush
