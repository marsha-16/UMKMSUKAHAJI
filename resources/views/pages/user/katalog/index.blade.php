@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Judul -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Katalog Produk UMKM</h2>
        <p class="text-muted">Temukan produk UMKM terbaik di Sukahaji</p>
    </div>

    <!-- Form Search & Filter -->
    <form method="GET" action="{{ route('katalog.index') }}" class="row g-2 mb-4">
        <div class="col-12 col-md-4">
            <input type="text" name="search" class="form-control" placeholder="🔍 Cari produk..." value="{{ request('search') }}">
        </div>
        <div class="col-6 col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="Harga Min" value="{{ request('min_price') }}">
        </div>
        <div class="col-6 col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="Harga Max" value="{{ request('max_price') }}">
        </div>
        <div class="col-6 col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('katalog.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>

    <!-- Grid Produk -->
    <div class="row">
        @forelse($katalogs as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0 product-card">
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                    @else
                        <img src="{{ asset('images/noimage.png') }}" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">{{ $item->name }}</h5>
                        <p class="card-text text-muted small mb-2">{{ Str::limit($item->description, 60) }}</p>
                        <p class="fw-bold text-success mb-3">Rp {{ number_format($item->price,0,',','.') }}</p>
                        <a href="{{ route('katalog.show',$item->id) }}" class="btn btn-primary btn-sm mt-auto">
                            <i class="bi bi-info-circle"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle-fill"></i> Produk tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $katalogs->links() }}
    </div>
</div>

<!-- Custom Style -->
<style>
    .product-card img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }
    .product-card:hover img {
        transform: scale(1.05);
    }
    .product-card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
        overflow: hidden;
    }
    .product-card:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
</style>
@endsection
