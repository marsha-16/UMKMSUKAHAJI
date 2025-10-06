@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4 align-items-center">

        <!-- Gambar Produk -->
        <div class="col-12 col-md-5 text-center">
            <div class="shadow rounded overflow-hidden bg-light p-2">
                @if($katalog->image)
                    <img src="{{ asset($katalog->image) }}" class="img-fluid rounded product-img">
                @else
                    <img src="{{ asset('images/noimage.png') }}" class="img-fluid rounded product-img">
                @endif
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="col-12 col-md-7">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h2 class="fw-bold text-dark mb-3">{{ $katalog->name }}</h2>
                <h4 class="fw-bold text-success mb-3">Rp {{ number_format($katalog->price,0,',','.') }}</h4>
                
                <p class="text-muted mb-3">{{ $katalog->description }}</p>

                <div class="mb-2">
                    <span class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger"></i> Alamat:</span> 
                    <span class="text-secondary">{{ $katalog->address ?? '-' }}</span>
                </div>

                <div class="mb-3">
                    <span class="fw-bold text-dark"><i class="bi bi-telephone-fill text-warning"></i> Telp:</span> 
                    <span class="text-secondary">{{ $katalog->phone ?? '-' }}</span>
                </div>

                <a href="{{ route('katalog.index') }}" class="btn btn-gradient mt-3">
                    <i class="bi bi-arrow-left-circle"></i> Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Style -->
<style>
    /* Warna sesuai logo: kuning - oranye - merah */
    .btn-gradient {
        background: linear-gradient(90deg, #FFC107, #FF5722, #DC3545);
        color: #fff;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .product-img {
        max-height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }
    .product-img:hover {
        transform: scale(1.05);
    }

    .card {
        border-radius: 12px;
    }

    /* Responsif */
    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem;
        }
        h4 {
            font-size: 1.2rem;
        }
        .btn-gradient {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection
