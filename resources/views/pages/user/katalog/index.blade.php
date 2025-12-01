@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Katalog</title>

<div class="container py-4">

    <!-- Judul -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark display-6">Katalog Produk UMKM</h2>
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
                        <p class="fw-bold text-dark mb-3">
                            {{ $item->price !== null && $item->price != 0 ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}
                        </p>

                        <!-- Tombol Detail memicu Modal -->
                        <button 
                            class="btn btn-theme btn-sm mt-auto text-dark fw-semibold"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal"
                            data-name="{{ $item->name }}"
                            data-price="{{ $item->price !== null && $item->price != 0 ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}"
                            data-description="{{ $item->description }}"
                            data-image="{{ $item->image ? asset($item->image) : asset('images/noimage.png') }}"
                            data-address="{{ $item->address ?? '-' }}"
                            data-phone="{{ $item->phone && $item->phone !== '' ? $item->phone : '-' }}">
                            <i class="bi bi-info-circle"></i> Detail
                        </button>
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

    <!-- Pagination -->
    <div class="d-flex justify-content-end align-items-center mt-3">
        <div style="display: flex; gap: 5px;">
            @if ($katalogs->onFirstPage())
                <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
            @else
                <a href="{{ $katalogs->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
            @endif

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

            @if ($katalogs->hasMorePages())
                <a href="{{ $katalogs->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
            @else
                <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Produk -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-body p-0">
        <div class="row g-0">
          <div class="col-md-5 text-center bg-light p-3">
            <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 350px; object-fit: cover;">
          </div>
          <div class="col-md-7 p-4">
            <h3 id="modalName" class="fw-bold text-dark mb-3"></h3>
            <h5 id="modalPrice" class="fw-bold text-dark mb-3"></h5>
            <p id="modalDescription" class="text-muted mb-3"></p>
            <p><i class="bi bi-geo-alt-fill text-danger"></i> <span id="modalAddress" class="text-secondary"></span></p>
            <p><i class="bi bi-telephone-fill text-warning"></i> <span id="modalPhone" class="text-secondary">Telp:</span></p>
            <div class="text-end">
              <button type="button" class="btn btn-gradient mt-3" data-bs-dismiss="modal"><i class="bi bi-arrow-left-circle"></i> Kembali ke Katalog</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script untuk isi data modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        document.getElementById('modalName').textContent = button.getAttribute('data-name');
        document.getElementById('modalPrice').textContent = button.getAttribute('data-price');
        document.getElementById('modalDescription').textContent = button.getAttribute('data-description');
        document.getElementById('modalImage').src = button.getAttribute('data-image');
        document.getElementById('modalAddress').textContent = button.getAttribute('data-address');
        document.getElementById('modalPhone').textContent = button.getAttribute('data-phone');
    });
});
</script>

<!-- Custom Style -->
<style>
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
    .product-card:hover {
        box-shadow: 0 8px 24px rgba(255, 140, 0, 0.25);
        transform: translateY(-3px);
        background: linear-gradient(180deg, rgba(255, 193, 7, 0.15), rgba(255, 87, 34, 0.05));
    }
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
    }
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
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
@endsection