@extends('layouts.resepsionis')

@section('title','Dashboard Resepsionis')

@section('content')

<div class="container-fluid mt-4">

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="fw-bold text-danger mb-1">
            <i class="fa fa-gauge-high me-2"></i>
            Dashboard Resepsionis
        </h4>

        <div class="text-muted">
            Selamat datang,
            {{ auth()->user()->name }} 👋
        </div>

        <div id="clock" class="text-muted small"></div>
    </div>

</div>


{{-- =========================
    CARD STATISTIK
==========================--}}
<div class="row mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">

                <div>
                    <small>Total Tamu Hari Ini</small>
                    <h3 class="fw-bold">
                        {{ $hariIni }}
                    </h3>
                </div>

                <i class="fa fa-users fa-2x text-danger"></i>

            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">

                <div>
                    <small>Total Tamu Bulan Ini</small>
                    <h3 class="fw-bold">
                        {{ $bulanIni }}
                    </h3>
                </div>

                <i class="fa fa-calendar fa-2x text-warning"></i>

            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between">

                <div>
                    <small>Total Tamu Minggu Ini</small>
                    <h3 class="fw-bold">
                        {{ $mingguIni }}
                    </h3>
                </div>

                <i class="fa fa-chart-line fa-2x text-dark"></i>

            </div>
        </div>
    </div>

</div>


{{-- =========================
    TABEL TAMU TERBARU
==========================--}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">
        <h6 class="fw-bold mb-0">
            Data Tamu Terbaru
        </h6>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">
                <tr>
                    <th>Nama Tamu</th>
                    <th>Pegawai Dituju</th>
                    <th>Keperluan</th>
                    <th>Petugas Penerima</th>
                    <th>Waktu Datang</th>
                </tr>
            </thead>

            <tbody>

            @forelse($tamus as $t)

            <tr>

                <td class="fw-semibold">
                    {{ $t->nama_lengkap }}
                </td>

                <td>
                    {{ $t->pegawai_dituju }}
                </td>

                <td>
                    {{ $t->keperluan }}
                </td>

                <td>
                    {{ $t->petugas_penerima }}
                </td>

                <td>
                    {{ $t->created_at->format('d-m-Y H:i') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada data tamu
                </td>
            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>
```-

</div>

{{-- CLOCK --}}

<script>
function updateClock(){

    const now = new Date();

    const options = {
        weekday:'long',
        year:'numeric',
        month:'long',
        day:'numeric'
    };

    document.getElementById('clock').innerHTML =
        now.toLocaleDateString('id-ID', options)
        +" • "+
        now.toLocaleTimeString('id-ID');

}

setInterval(updateClock,1000);
updateClock();
</script>

@endsection
