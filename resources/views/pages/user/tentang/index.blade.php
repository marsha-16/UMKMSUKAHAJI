@extends('layouts.app')

@section('content')
<!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            <i>Revolusi Aksi Perubahan</i>
        </h2>
    </div>

<div class="row">
     @forelse($tentangs as $tentang)
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 h-100">
                @if(strtoupper($tentang->judul) == 'LATAR BELAKANG MASALAH')
                @elseif(strtoupper($tentang->judul) == 'INOVASI DAN TEROBOSAN')
                @elseif(strtoupper($tentang->judul) == 'KESIMPULAN')
                @endif
                <div class="card-header text-white fw-bold gradient-header">
                    {{ strtoupper($tentang->judul) }}
                </div>
                <div class="card-body">
                    <p class="profil-content">{{ $tentang->deskripsi }}</p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Belum ada data.</p>
    @endforelse
</div>

<!-- Custom Styling -->
<style>
    /* Gradient sesuai logo UMKM (kuning - oranye - merah) */
    .btn-gradient {
        background: linear-gradient(135deg, #f7c948, #f59e0b, #dc2626);
        border: none;
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    /* Header Card dengan gradient */
    .gradient-header {
        background: linear-gradient(135deg, #f7c948, #f59e0b, #dc2626);
        border-bottom: none;
        font-size: 1rem;
        letter-spacing: 0.5px;
    }
</style>
@endsection
