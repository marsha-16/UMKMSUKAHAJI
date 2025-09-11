@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Profile</h1>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session()->get('success') }}",
                icon: "success"
            });
        </script>
    @endif
    <div class="row">
        <div class="col">
            @php
                $guard = auth('admin')->check() ? 'admin' : 'web';
                $user = auth($guard)->user();
            @endphp

            <form action="/profile/{{ auth()->user()->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3 text-center">
                            <div class="position-relative d-inline-block" style="cursor: pointer;">
                                @if(Auth::guard('admin')->check())
                                {{-- Admin = biru --}}
                                <span class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                      style="width: 120px; height: 120px;">
                                    <i class="fas fa-user-circle text-white" style="font-size: 70px;"></i>
                                </span>
                            @else
                                {{-- User = abu-abu --}}
                                <span class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto"
                                      style="width: 120px; height: 120px;">
                                    <i class="fas fa-user-circle text-white" style="font-size: 70px;"></i>
                                </span>
                            @endif 
                            </div>
                        </div>                           
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" readonly>
                            @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                        <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 10px;">
                            @if(Auth::guard('admin')->check())
                                <a href="/dashboardAdmin" class="btn btn-outline-secondary">
                                    Kembali
                                </a>
                            @elseif(Auth::guard('web')->check())
                                <a href="/dashboard" class="btn btn-outline-secondary">
                                    Kembali
                                </a>
                            @endif
                            <button type="submit" class="btn btn-warning">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection