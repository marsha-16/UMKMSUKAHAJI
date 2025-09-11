@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat UMKM Sukahaji</h1>
</div>

<div class="row">
    <div class="col">
        <form action="/pemetaan" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card">
                <div class="card-body">
                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="form-group mb-3">
                        <label for="nik">NIK</label>
                        <input type="number" inputmode="numeric" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                        @error('nik')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" cols="30" rows="5" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group mb-3">
                        <label for="phone">No Telepon</label>
                        <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Usaha -->
                    <div class="form-group mb-3">
                        <label for="business">Jenis Usaha</label>
                        <select name="business" id="business" class="form-control @error('business') is-invalid @enderror">
                            @foreach ([
                                'Warung Kelontong',
                                'Makanan dan Minuman',
                                'Sayur Mayur dan Daging',
                                'Pakaian',
                                'Jajanan Pasar',
                                'Jasa Fotocopy',
                                'Servis Elektronik',
                                'Jasa Sumur Bor',
                                'Kaligrafi',
                                'Air Isi Ulang',
                                'Jasa Tenaga',
                                'Refill Parfum',
                                'Olahraga dan Hiburan',
                                'Jual Beli Hewan Ternak',
                                'Buah-Buahan',
                                'Home Industri',
                                'Konter Handphone',
                                ' Accessories'
                            ] as $item)
                                <option value="{{ $item }}" @selected(old('business') == $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('business')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Pemasaran -->
                    <div class="form-group mb-3">
                        <label for="marketing">Jenis Pemasaran</label>
                        <select name="marketing" id="marketing" class="form-control @error('marketing') is-invalid @enderror">
                            @foreach (['Tunai', 'Online'] as $item)
                                <option value="{{ $item }}" @selected(old('marketing') == $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('marketing')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Platform Digital -->
                    <div class="form-group mb-3">
                        <label for="promotion">Platform Digital</label>
                        <select name="promotion" id="promotion" class="form-control @error('promotion') is-invalid @enderror">
                            @foreach (['Whatsapp','Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab'] as $item)
                                <option value="{{ $item }}" @selected(old('promotion') == $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('promotion')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Dokumen Penunjang -->
                    <div class="form-group mb-3">
                        <label for="document">Dokumen Penunjang</label>
                        <select name="document" id="document" class="form-control @error('document') is-invalid @enderror">
                            @foreach (['Nomor Induk Berusaha','Sertifikat Halal','Pangan Industri Rumah Tangga','Belum Punya','Dalam Proses'] as $item)
                                <option value="{{ $item }}" @selected(old('document') == $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('document')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Footer sejajar tombol -->
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div style="gap:10px;">
                        <a href="/pemetaan" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
