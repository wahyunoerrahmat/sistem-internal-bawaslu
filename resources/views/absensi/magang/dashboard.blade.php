@extends('layouts.magang')

@section('title', 'Dashboard Magang')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Dashboard Magang</h4>
        <small class="text-muted">
            Statistik riwayat absensi Anda
        </small>
    </div>

    <div class="row g-4">

        <!-- ================= TOTAL ABSENSI ================= -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Absensi</small>
                        <h3 class="fw-bold text-danger mb-0">
                            {{ $total }}
                        </h3>
                    </div>
                    <i class="bi bi-clipboard-check fs-1 text-danger"></i>
                </div>
            </div>
        </div>

        <!-- ================= TEPAT WAKTU ================= -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Tepat Waktu</small>
                        <h3 class="fw-bold text-success mb-0">
                            {{ $totalMasuk }}
                        </h3>
                    </div>
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                </div>
            </div>
        </div>

        <!-- ================= TERLAMBAT ================= -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Terlambat</small>
                        <h3 class="fw-bold text-warning mb-0">
                            {{ $totalTerlambat }}
                        </h3>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                </div>
            </div>
        </div>

        <!-- ================= BULAN INI ================= -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Kehadiran Bulan Ini</small>
                        <h3 class="fw-bold text-primary mb-0">
                            {{ $bulanIni }}
                        </h3>
                    </div>
                    <i class="bi bi-calendar-check fs-1 text-primary"></i>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection