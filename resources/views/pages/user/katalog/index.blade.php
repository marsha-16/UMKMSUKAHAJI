@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Judul -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark display-6">🛍️ Katalog Produk UMKM</h2>
        <p class="text-secondary">Temukan produk unggulan UMKM terbaik di Sukahaji</p>
    </div>

    <!-- Form Search & Filter -->
    <form method="GET" action="{{ route('katalog.index') }}" class="row g-2 mb-4 justify-content-center">
        <div class="col-12 col-md-4">
            <input type="text" name="search" class="form-control form-control-lg shadow-sm"
                placeholder="🔍 Cari produk..." value="{{ request('search') }}">
        </div>
        <div class="col-6 col-md-2">
            <input type="number" name="min_price" class="form-control form-control-lg shadow-sm"
                placeholder="Harga Min" value="{{ request('min_price') }}">
        </div>
        <div class="col-6 col-md-2">
            <input type="number" name="max_price" class="form-control form-control-lg shadow-sm"
                placeholder="Harga Max" value="{{ request('max_price') }}">
        </div>
        <div class="col-6 col-md-2 d-grid">
            <button class="btn btn-warning btn-lg fw-semibold shadow-sm text-dark">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
        <div class="col-6 col-md-2 d-grid">
            <a href="{{ route('katalog.index') }}" class="btn btn-outline-secondary btn-lg fw-semibold shadow-sm">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>

    <!-- Grid Produk -->
    <div class="row justify-content-center">
        @forelse($katalogs as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="overflow-hidden rounded-top">
                        @if($item->image)
                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                        @else
                            <img src="{{ asset('images/noimage.png') }}" class="card-img-top" alt="No Image">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-bold text-dark mb-2">{{ $item->name }}</h5>
                        <p class="text-muted small mb-2">{{ Str::limit($item->description, 60) }}</p>
                        <p class="fw-bold text-dark mb-3">Rp {{ number_format($item->price,0,',','.') }}</p>
                        <a href="{{ route('katalog.show',$item->id) }}" class="btn btn-theme btn-sm mt-auto text-dark fw-semibold">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center shadow-sm">
                    <i class="bi bi-info-circle-fill"></i> Produk tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Info jumlah -->
        <div class="text-center text-muted small mb-3">
            Menampilkan {{ $katalogs->firstItem() }} - {{ $katalogs->lastItem() }} dari total {{ $katalogs->total() }} produk
        </div>

        <!-- Pagination di kanan bawah -->
        <div class="d-flex justify-content-end align-items-center mt-3">
            <div style="display: flex; gap: 5px;">
                {{-- Tombol Prev --}}
                @if ($katalogs->onFirstPage())
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                @else
                    <a href="{{ $katalogs->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                @endif

                {{-- Nomor halaman terbatas 3 --}}
                @php
                    $start = max($katalogs->currentPage() - 1, 1);
                    $end = min($katalogs->currentPage() + 1, $katalogs->lastPage());
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $katalogs->currentPage())
                        <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                    @else
                        <a href="{{ $katalogs->url($page) }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Tombol Next --}}
                @if ($katalogs->hasMorePages())
                    <a href="{{ $katalogs->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                @else
                    <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                @endif
            </div>
        </div>
</div>

<!-- Custom Style -->
<style>
    /* ====== Tampilan Katalog UMKM ====== */

    .product-card {
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        background-color: #fff;
        position: relative;
    }

    .product-card img {
        height: 220px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover img {
        transform: scale(1.08);
    }

    /* Hover effect oranye lembut di seluruh kartu */
    .product-card:hover {
        box-shadow: 0 8px 24px rgba(255, 140, 0, 0.25);
        transform: translateY(-3px);
        background: linear-gradient(180deg, rgba(255, 193, 7, 0.15), rgba(255, 87, 34, 0.05));
    }

    /* Tombol tema merah–orange–kuning dengan teks hitam */
    .btn-theme {
        background: linear-gradient(45deg, #ff6b6b, #feca57, #f8c291);
        border: none;
        color: #000 !important;
        font-weight: 600;
        transition: all 0.3s ease;
        background-size: 200% 200%;
        animation: gradientMove 4s ease infinite;
    }

    .btn-theme:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        color: #000 !important;
    }

    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .btn, .form-control {
        border-radius: 10px;
    }

    /* Responsif di HP */
    @media (max-width: 576px) {
        h2 {
            font-size: 1.6rem;
        }
        .form-control-lg, .btn-lg {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }
        .product-card img {
            height: 180px;
        }
    }
</style>
@endsection
