@extends('layouts.admin-barang')

@section('title', 'Dashboard Admin Barang')

@section('content')

<div class="container-fluid">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-danger mb-1">
            <i class="bi bi-speedometer2"></i> Dashboard Admin Barang
        </h4>
        <small class="text-muted">
            Ringkasan data inventaris barang
        </small>
    </div>
</div>


<!-- FILTER TANGGAL -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-funnel"></i> Filter Data
    </div>

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ request('tanggal_mulai') }}"
                        class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="form-control">
                </div>

                <div class="col-md-4 d-flex align-items-end">

                    <button class="btn btn-danger me-2">
                        <i class="bi bi-search"></i> Filter
                    </button>

                    <a href="{{ url()->current() }}" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- STATISTIK -->
<div class="row g-4 mb-4">

    <!-- TOTAL BARANG -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-danger fs-1">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>
                    <div class="text-muted">Total Barang</div>
                    <h3 class="fw-bold mb-0">{{ $totalBarang }}</h3>
                    <small class="text-muted">Seluruh aset tercatat</small>
                </div>

            </div>

        </div>
    </div>


    <!-- BARANG TERSEDIA -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-success fs-1">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <div class="text-muted">Barang Tersedia</div>
                    <h3 class="fw-bold mb-0">{{ $barangTersedia }}</h3>
                    <small class="text-muted">Siap dipinjam</small>
                </div>

            </div>

        </div>
    </div>


    <!-- BARANG DIPINJAM -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-warning fs-1">
                    <i class="bi bi-arrow-left-right"></i>
                </div>

                <div>
                    <div class="text-muted">Barang Dipinjam</div>
                    <h3 class="fw-bold mb-0">{{ $barangDipinjam }}</h3>
                    <small class="text-muted">Sedang digunakan</small>
                </div>

            </div>

        </div>
    </div>

</div>


<!-- GRAFIK -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-bar-chart"></i> Grafik Aktivitas Barang
    </div>

    <div class="card-body" style="height:350px">
        <canvas id="chartPeminjaman"></canvas>
    </div>

</div>


<!-- INFORMASI SISTEM -->
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-info-circle"></i> Informasi Sistem
    </div>

    <div class="card-body">
        Sistem Internal Bawaslu digunakan untuk mengelola inventaris barang,
        peminjaman barang, serta monitoring aset yang digunakan oleh pegawai.
    </div>

</div>

</div>

<!-- CHART JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartPeminjaman');

new Chart(ctx, {

    type: 'line',

    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: 'Jumlah Aktivitas Barang',
            data: {!! json_encode($data) !!},
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220,53,69,0.2)',
            tension: 0.3,
            fill: true
        }]
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                display: true
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }

    }

});

</script>

@endsection
