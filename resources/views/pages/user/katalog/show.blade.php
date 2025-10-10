@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Katalog</title>
  
<div class="container py-4 fade-in">
    <div class="row g-4 align-items-center">

        <!-- Gambar Produk -->
        <div class="col-12 col-md-5 text-center">
            <div class="shadow rounded overflow-hidden bg-light p-2 h-100">
                @if($katalog->image)
                    <img src="{{ asset($katalog->image) }}" class="img-fluid rounded product-img" alt="Gambar Produk">
                @else
                    <img src="{{ asset('images/noimage.png') }}" class="img-fluid rounded product-img" alt="Tidak ada gambar">
                @endif
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="col-12 col-md-7">
            <div class="card border-0 shadow-sm p-4 h-100 hover-card">
                <h2 class="fw-bold text-dark mb-3">{{ $katalog->name }}</h2>

                <!-- Harga warna hitam -->
                <h4 class="fw-bold text-dark mb-3">Rp {{ number_format($katalog->price,0,',','.') }}</h4>

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
    /* Tombol gradien warna logo */
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

    /* Gambar produk */
    .product-img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }
    .product-img:hover {
        transform: scale(1.05);
    }

    /* Kartu detail produk */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    /* Hover effect oranye lembut */
    .hover-card:hover {
        background-color: rgba(255, 165, 0, 0.08);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(255, 87, 34, 0.2);
    }

    /* Fade-in effect saat halaman dibuka */
    .fade-in {
        opacity: 0;
        animation: fadeInAnim 0.8s ease-in-out forwards;
    }
    @keyframes fadeInAnim {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsif */
    @media (max-width: 992px) {
        .product-img {
            max-height: 300px;
        }
    }

    @media (max-width: 768px) {
        .product-img {
            max-height: 250px;
        }
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

    @media (max-width: 576px) {
        .card {
            padding: 1.2rem;
        }
    }
</style>
@endsection
