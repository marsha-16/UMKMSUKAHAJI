@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <!-- Tambahkan Foto -->
                    <img src="{{ asset('images/logo.png') }}" alt="Pemetaan UMKM Kelurahan Sukahaji" 
                         class="img-fluid mb-3 rounded" style="max-height:250px;">
                         <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>
                         <p>Dari halaman ini, Anda dapat melihat notifikasi terbaru, dan status pemetaan UMKM anda</p>
                </div>
            </div>
        </div>
    </div>
@endsection
