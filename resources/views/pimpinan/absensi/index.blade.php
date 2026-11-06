@extends('layouts.pimpinan')

@section('title', 'Data Absensi')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-1">
            <i class="bi bi-calendar-check-fill"></i> Data Absensi
        </h4>
        <p class="text-muted mb-0">
            Daftar seluruh data absensi pegawai.
        </p>
    </div>

    <!-- Filter Section (Optional jika ada filter) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <option value="">Semua</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <!-- lanjutkan sesuai kebutuhan -->
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            <option value="2026">2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-funnel-fill"></i> Filter Data
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($absensi as $absen)
                        <tr>
                            <td class="fw-semibold">
                                {{ $absen->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
                            </td>

                            <td>
                                @if($absen->status === 'hadir')
                                    <span class="badge bg-success">
                                        Hadir
                                    </span>
                                @elseif($absen->status === 'tidak_hadir')
                                    <span class="badge bg-danger">
                                        Tidak Hadir
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $absen->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle"></i>
                                Belum ada data absensi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination (jika pakai paginate) -->
            <div class="mt-3">
                {{ $absensi->links() }}
            </div>

        </div>
    </div>

</div>

@endsection