@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Tentang UMKM</h2>
    <form action="{{ route('admin.tentang.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
