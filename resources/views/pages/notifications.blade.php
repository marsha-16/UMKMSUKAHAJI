@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Notifikasi</title>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semua Notifikasi</h1>
    </div>

    <div class="row">
        @foreach (auth()->user()->notifications as $notification)
        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-body" style="background-color: rgba(115, 194, 251, {{ is_null($notification->read_at) ? '0.2' : '0.0'}});">
                    <div class="row">
                        <div class="col-1">{{ $loop->iteration }}</div>
                        <div class="col-9">{{ $notification->data['message'] }}</div>
                        @if (is_null($notification->read_at))
                        <div class="col-2">
                            <form action="/notification/{{ $notification->id }}/read" method="post">
                                @csrf
                                @method('POST')
                                    <button type="submit" class="btn btn-sm btn-primary btn-block">Tandai Telah Dibaca</button> 
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection