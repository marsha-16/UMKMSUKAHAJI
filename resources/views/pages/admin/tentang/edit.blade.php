@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Tentang UMKM</h2>
    <form action="{{ route('admin.tentang.update', $tentang->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $tentang->judul }}" class="form-control">
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $tentang->deskripsi }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
