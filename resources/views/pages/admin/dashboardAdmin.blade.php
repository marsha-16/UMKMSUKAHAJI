@extends('layouts.app')

@section('content')
<title>UMKM Sukahaji - Dashboard Admin</title>

<div class="container-fluid">
    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Statistik Status -->
    <div class="row mb-4">
        @php
            $statusCards = [
                ['id' => 'totalApprove', 'label' => '✅ Diterima',  'status' => 'approve'],
                ['id' => 'totalProcess', 'label' => '⏳ Diproses',  'status' => 'process'],
                ['id' => 'totalRejected', 'label' => '❌ Ditolak',  'status' => 'rejected'],
                ['id' => 'totalAll', 'label' => '📊 Total',  'status' => 'all'],
            ];
        @endphp

        @foreach($statusCards as $index => $card)
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card shadow h-100 border-0 status-card cursor-pointer animated-bg"
                data-status="{{ $card['status'] }}"
                style="color:#fff; opacity:0; transform: translateY(30px); transition: all 0.6s ease {{ $index * 0.2 }}s;">
                <div class="card-body text-center">
                    <h6 class="font-weight-bold">{{ $card['label'] }}</h6>
                    <div class="shimmer mx-auto" style="width:60px; height:32px; border-radius:6px;"></div>
                    <h3 class="font-weight-bold mb-0 d-none" id="{{ $card['id'] }}">0</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Diagram Jenis Usaha (Bar Horizontal di atas tabel) -->
    <div class="row justify-content-center mt-4">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-white text-center">
                    <h6 class="m-0 font-weight-bold text-primary">Diagram Jenis Usaha</h6>
                </div>
                <div class="card-body text-center">

                    <!-- Diagram Batang Horizontal -->
                    <div class="chart-container mx-auto mb-4">
                        <canvas id="usahaBarChart"></canvas>
                    </div>

                    <!-- Tabel Detail -->
                    <div class="table-responsive">
                        <h6 class="mb-3 text-center">Detail Jumlah per Jenis Usaha</h6>
                        <table class="table table-sm table-bordered text-center mb-0 shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis Usaha</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="usahaTableBody"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Efek shimmer loading */
.shimmer {
  position: relative;
  background: #f6f7f8;
  overflow: hidden;
}
.shimmer::after {
  content: "";
  position: absolute;
  top: 0;
  left: -150px;
  height: 100%;
  width: 150px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.6), transparent);
  animation: shimmer 1.2s infinite;
}
@keyframes shimmer {
  100% { transform: translateX(300px); }
}

/* Animasi background gradasi */
.animated-bg {
  background: linear-gradient(135deg, #f7c948, #f59e0b, #dc2626, #111827);
  background-size: 300% 300%;
  animation: gradientMove 8s ease infinite;
}
@keyframes gradientMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Chart container */
.chart-container {
  position: relative;
  width: 100%;
  max-width: 700px;
  height: 450px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .chart-container {
    height: 350px;
  }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Fungsi animasi angka
    function animateCount(id, target) {
        let el = document.getElementById(id);
        let current = 0;
        let increment = Math.ceil(target / 50);
        let timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.innerText = current;
        }, 30);
    }

    // Fade-in kartu status
    setTimeout(() => {
        document.querySelectorAll('.status-card').forEach(card => {
            card.style.opacity = 1;
            card.style.transform = 'translateY(0)';
        });
    }, 200);

    // Hover animasi kartu
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05)';
            card.style.boxShadow = '0 0.5rem 1rem rgba(0,0,0,.15)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
            card.style.boxShadow = '0 .125rem .25rem rgba(0,0,0,.075)';
        });
    });

    // Ambil data jenis usaha (untuk chart dan tabel)
    fetch("{{ route('chart.data') }}")
        .then(response => response.json())
        .then(data => {
            const labels = Object.keys(data);
            const values = Object.values(data);
            const colors = labels.map(() =>
                `hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`
            );

            const ctx = document.getElementById('usahaBarChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Jumlah Usaha',
                        data: values,
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 1,
                        borderRadius: 8,
                        barThickness: 20
                    }]
                },
                options: {
                    indexAxis: 'y', // 🔹 Bar horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: '#374151',
                                font: { size: 12 },
                                stepSize: 1
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        y: {
                            ticks: { color: '#374151', font: { size: 12 } },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#111',
                            bodyColor: '#111',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            displayColors: true,
                            padding: 8
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutCubic'
                    }
                }
            });

            // Isi tabel
            const tbody = document.getElementById("usahaTableBody");
            tbody.innerHTML = "";
            labels.forEach((label, i) => {
                tbody.innerHTML += `
                    <tr>
                        <td style="color:${colors[i]}"><strong>${label}</strong></td>
                        <td><strong>${values[i]}</strong></td>
                    </tr>
                `;
            });
        });

    // Ambil data status
    fetch("{{ route('status.counts') }}")
        .then(response => response.json())
        .then(data => {
            ["totalApprove","totalProcess","totalRejected","totalAll"].forEach(id => {
                let el = document.getElementById(id);
                el.previousElementSibling.remove(); // hapus shimmer
                el.classList.remove("d-none");
            });

            animateCount("totalApprove", data.approve ?? 0);
            animateCount("totalProcess", data.process ?? 0);
            animateCount("totalRejected", data.rejected ?? 0);
            animateCount("totalAll", (data.approve ?? 0) + (data.process ?? 0) + (data.rejected ?? 0));
        });

    // Klik kartu menuju halaman pemetaan
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('click', () => {
            let status = card.dataset.status;
            let url = "{{ url('/pemetaan') }}";
            if (status !== 'all') {
                url += `?status=${status}`;
            }
            window.location.href = url;
        });
    });
});
</script>
@endpush

@push('scripts')
@if (session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: "Login Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "OK",
        confirmButtonColor: "#3085d6"
    });
});
</script>
@endif
@endpush
