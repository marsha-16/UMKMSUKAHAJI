@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Tentang UMKM</title>

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

                <div class="card-header text-white fw-bold gradient-header">
                    {{ strtoupper($tentang->judul) }}
                </div>

                <div class="card-body">
                    {{-- Auto deteksi link dan ubah jadi hyperlink --}}
                    <p class="profil-content">{!! makeClickableLinks($tentang->deskripsi) !!}</p>
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

    /* Link dalam deskripsi */
    .profil-content a {
        color: #f97316;
        text-decoration: underline;
        transition: 0.2s;
        word-break: break-all;
    }
    .profil-content a:hover {
        color: #dc2626;
        text-decoration: none;
    }
</style>
@endsection

@php
/**
 * Fungsi bantu untuk mengubah URL menjadi link bisa diklik
 */
function makeClickableLinks($text) {
    // Escape HTML dulu supaya aman
    $text = e($text);

    // Deteksi URL dan ubah jadi hyperlink
    $text = preg_replace(
        '/(https?:\/\/[^\s<]+)/i',
        '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
        $text
    );

    // Ganti newline jadi <br>
    return nl2br($text);
}
@endphp
