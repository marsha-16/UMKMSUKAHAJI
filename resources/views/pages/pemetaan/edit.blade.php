@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Pemetaan</title>
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
                                @php
                                    $defaultBusinesses = [
                                        'Warung Kelontong', 'Makanan dan Minuman', 'Sayur Mayur dan Daging',
                                        'Pakaian', 'Jajanan Pasar', 'Jasa Fotocopy',
                                        'Servis Elektronik', 'Jasa Sumur Bor', 'Yang Lain'
                                    ];
                                    $currentBusiness = old('business', $pemetaan->business);
                                    $isCustomBusiness = !in_array($currentBusiness, $defaultBusinesses);
                                @endphp

                                @foreach ($defaultBusinesses as $item)
                                    <option value="{{ $item }}"
                                        @selected($currentBusiness == $item || ($isCustomBusiness && $item == 'Yang Lain'))>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                            @error('business')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Yang Lain -->
                        <div class="form-group mb-3" id="otherField"
                            style="{{ $currentBusiness == 'Yang Lain' || $isCustomBusiness ? '' : 'display:none;' }}">
                            <label for="other">Yang Lain</label>
                            <textarea name="other" id="other" cols="30" rows="5"
                                class="form-control @error('other') is-invalid @enderror">{{ old('other', $isCustomBusiness ? $pemetaan->business : '') }}</textarea>
                            @error('other')
                                <span class="invalid-feedback">{{ $message }}</span>
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
                                        (object) [
                                            'label' => 'Offline',
                                            'value' => 'Offline',
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

                        <!-- Upload Foto Dokumen -->
                        <div class="form">
                            <label for="document_photo" class="d-block">Upload Foto Dokumen</label>

                            @if ($pemetaan->document_photo)
                                <img id="previewImage" 
                                    src="{{ asset($pemetaan->document_photo) }}" 
                                    alt="Foto Dokumen" 
                                    class="img-thumbnail mb-2" 
                                    style="max-width: 200px;">
                            @else
                                <img id="previewImage" 
                                    src="https://via.placeholder.com/200x150?text=Belum+Ada+Foto" 
                                    alt="Foto Dokumen" 
                                    class="img-thumbnail mb-2" 
                                    style="max-width: 200px;">
                            @endif

                            <input type="file" name="document_photo" id="document_photo"
                                class="form-control-file mt-2 @error('document_photo') is-invalid @enderror"
                                accept="image/*" onchange="previewFile(event)">

                            @error('document_photo')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
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

    <script>
function previewFile(event) {
    const input = event.target;
    const file = input.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result; // ganti src jadi file baru
        }
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const businessSelect = document.getElementById('business');
    const otherField = document.getElementById('otherField');
    const otherInput = document.getElementById('other');

    function toggleOtherField() {
        if (businessSelect.value === 'Yang Lain') {
            otherField.style.display = '';
            otherInput.required = true;
        } else {
            otherField.style.display = 'none';
            otherInput.required = false;
            otherInput.value = ''; // kosongkan kalau ganti pilihan
        }
    }

    businessSelect.addEventListener('change', toggleOtherField);
});
</script>

@endsection