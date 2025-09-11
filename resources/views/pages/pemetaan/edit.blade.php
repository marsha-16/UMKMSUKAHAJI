@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data UMKM</h1>
    </div>
    <div class="row">
        <div class="col">
            <form action="/pemetaan/{{ $pemetaan->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pemetaan->name) }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="number" inputmode="numeric" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $pemetaan->nik) }}">
                            @error('nik')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="address">Alamat</label>
                            <textarea name="address" id="address" cols="30" rows="10" class="form-control @error('address') is-invalid @enderror">{{ old('address', $pemetaan->address) }}</textarea>
                            @error('address')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">No Telepon</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $pemetaan->phone) }}">
                            @error('phone')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="business">Jenis Usaha</label>
                            <select name="business" id="business" class="form-control @error('business') is-invalid @enderror">
                                @foreach ([
                                    (object) [
                                        "label" => "Warung Kelontong",
                                        "value" => "Warung Kelontong",
                                    ],
                                    (object) [
                                        "label" => "Makanan dan Minuman",
                                        "value" => "Makanan dan Minuman",
                                    ],
                                    (object) [
                                        "label" => "Sayur Mayur dan Daging",
                                        "value" => "Sayur Mayur dan Daging",
                                    ],
                                    (object) [
                                        "label" => "Pakaian",
                                        "value" => "Pakaian",
                                    ],
                                    (object) [
                                        "label" => "Jajanan Pasar",
                                        "value" => "Jajanan Pasar",
                                    ],
                                    (object) [
                                        "label" => "Jasa Fotocopy",
                                        "value" => "Jasa Fotocopy",
                                    ],
                                    (object) [
                                        "label" => "Servis Elektronik",
                                        "value" => "Servis Elektronik",
                                    ],
                                    (object) [
                                        "label" => "Jasa Sumur Bor",
                                        "value" => "Jasa Sumur Bor",
                                    ],
                                    (object) [
                                        "label" => "Kaligrafi",
                                        "value" => "Kaligrafi",
                                    ],
                                    (object) [
                                        "label" => "Air Isi Ulang",
                                        "value" => "Air Isi Ulang",
                                    ],
                                    (object) [
                                        "label" => "Jasa Tenaga",
                                        "value" => "Jasa Tenaga",
                                    ],
                                    (object) [
                                        "label" => "Refill Parfum",
                                        "value" => "Refill Parfum",
                                    ],
                                    (object) [
                                        "label" => "Olahraga dan Hiburan",
                                        "value" => "Olahraga dan Hiburan",
                                    ],
                                    (object) [
                                        "label" => "Jual Beli Hewan Ternak",
                                        "value" => "Jual Beli Hewan Ternak",
                                    ],
                                    (object) [
                                        "label" => "Buah-Buahan",
                                        "value" => "Buah-Buahan",
                                    ],
                                    (object) [
                                        "label" => "Home Industri",
                                        "value" => "Home Industri",
                                    ],
                                    (object) [
                                        "label" => "Konter Handphone",
                                        "value" => "Konter Handphone",
                                    ],
                                    (object) [
                                        "label" => "Accessories",
                                        "value" => "Accessories",
                                    ],
                                ] as $item)
                                <option value="{{ $item->value }}" @selected(old('business', $pemetaan->business) == $item->value)>{{ $item->label }}</option>
                                @endforeach
                            </select>
                            @error('business')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                            <div class="form-group mb-3">
                                <label for="marketing">Jenis Pemasaran</label>
                                <select name="marketing" id="marketing" class="form-control @error('marketing') is-invalid @enderror">
                                    @foreach ([
                                        (object) [
                                            'label' => 'Tunai',
                                            'value' => 'Tunai',
                                        ],
                                        (object) [
                                            'label' => 'Online',
                                            'value' => 'Online',
                                        ],
                                    ] as $item)
                                        <option value="{{ $item->value }}" @selected(old('marketing', $pemetaan->marketing) == $item->value)>{{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('marketing')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="promotion">Platform Digital</label>
                                <select name="promotion" id="promotion" class="form-control @error('promotion') is-invalid @enderror">
                                    @foreach ([
                                        (object) [
                                            'label' => 'Whatsapp',
                                            'value' => 'Whatsapp',
                                        ],
                                        (object) [
                                            'label' => 'Facebook',
                                            'value' => 'Facebook',
                                        ],
                                        (object) [
                                            'label' => 'Instagram',
                                            'value' => 'Instagram',
                                        ],
                                        (object) [
                                            'label' => 'TikTok',
                                            'value' => 'TikTok',
                                        ],
                                        (object) [
                                            'label' => 'Shopee',
                                            'value' => 'Shopee',
                                        ],
                                        (object) [
                                            'label' => 'Tokopedia',
                                            'value' => 'Tokopedia',
                                        ],
                                        (object) [
                                            'label' => 'Gojek/Grab',
                                            'value' => 'Gojek/Grab',
                                        ],
                                    ] as $item)
                                        <option value="{{ $item->value }}" @selected(old('promotion', $pemetaan->promotion) == $item->value)>{{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('promotion')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="document">Dokumen Penunjang</label>
                                <select name="document" id="document" class="form-control @error('document') is-invalid @enderror">
                                    @foreach ([
                                        (object) [
                                            'label' => 'Nomor Induk Berusaha',
                                            'value' => 'Nomor Induk Berusaha',
                                        ],
                                        (object) [
                                            'label' => 'Sertifikat Halal',
                                            'value' => 'Sertifikat Halal',
                                        ],
                                        (object) [
                                            'label' => 'Pangan Industri Rumah Tangga',
                                            'value' => 'Pangan Industri Rumah Tangga',
                                        ],
                                        (object) [
                                            'label' => 'Belum Punya',
                                            'value' => 'Belum Punya',
                                        ],
                                        (object) [
                                            'label' => 'Dalam Proses',
                                            'value' => 'Dalam Proses',
                                        ],
                                    ] as $item)
                                        <option value="{{ $item->value }}" @selected(old('document', $pemetaan->document) == $item->value)>{{ $item->label }}</option>
                                    @endforeach
                                </select>
                                @error('document')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
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