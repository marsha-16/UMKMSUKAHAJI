@extends('layouts.app')

@section('content')
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Akun UMKM</h1>
                    </div>

                    @if (session('success'))
                    <script>
                        Swal.fire({
                            title: "Berhasil",
                            text: "{{ session()->get('success') }}",
                            icon: "success"
                        });
                    </script>
                    @endif

                    {{-- Table --}}
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div style="overflow-x: auto;">
                                        <table class="table table-bordered table-hovered" style="min-width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            @if (count($users) < 1)
                                                <tbody>
                                                    <tr>
                                                        <td colspan="11">
                                                            <p class="pt-3 text-center">Tidak Ada Data</p>
                                                        </td>
                                                    </tr>
                                                </tbody>                                        
                                            @else
                                                <tbody>
                                                    @foreach ($users as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>
                                                            @if ($item->status == 'approved')
                                                                <span class="badge badge-success">Aktif</span>
                                                            @else
                                                                <span class="badge badge-danger"> Tidak Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex" style="gap: 10px;">
                                                                    @if ($item->status == 'approved')
                                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                                                            Non-Aktifkan Akun
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                                                            Aktifkan Akun
                                                                        </button>
                                                                    @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('pages.account-list.confirmation-approve')
                                                    @include('pages.account-list.confirmation-reject')
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                @if ($users->lastPage() > 1)
                                    <div style="margin: 10px 20px 40px 20px; display: flex; justify-content: space-between; align-items: center;">
                                        
                                        {{-- Info jumlah data --}}
                                        <div style="font-size: 14px; color: #374151;">
                                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                                        </div>

                                        {{-- Pagination --}}
                                        <div style="display: flex; gap: 5px;">
                                            {{-- Tombol Prev --}}
                                            @if ($users->onFirstPage())
                                                <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">&laquo; Prev</span>
                                            @else
                                                <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">&laquo; Prev</a>
                                            @endif

                                            {{-- Nomor halaman terbatas 3 --}}
                                            @php
                                                $start = max($users->currentPage() - 1, 1);
                                                $end = min($users->currentPage() + 1, $users->lastPage());
                                            @endphp

                                            @for ($page = $start; $page <= $end; $page++)
                                                @if ($page == $users->currentPage())
                                                    <span style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px;">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $users->url($page) }}" style="padding: 6px 12px; background: #fde68a; color: #374151; border-radius: 5px; text-decoration: none;">{{ $page }}</a>
                                                @endif
                                            @endfor

                                            {{-- Tombol Next --}}
                                            @if ($users->hasMorePages())
                                                <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: #f97316; color: white; border-radius: 5px; text-decoration: none;">Next &raquo;</a>
                                            @else
                                                <span style="padding: 6px 12px; background: #fcd9b6; border-radius: 5px; color: #9ca3af;">Next &raquo;</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
@endsection