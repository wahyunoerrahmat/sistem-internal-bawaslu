@extends('layouts.resepsionis')

@section('title','Statistik Kunjungan')

@section('content')

<div class="container-fluid mt-4">

    {{-- HEADER --}}
<div class="mb-4">

<h4 class="fw-bold text-danger mb-0">
    <i class="fa fa-chart-line me-2"></i>
    Statistik Kunjungan Tamu
</h4>

</div>


    {{-- ===============================
        KPI STATISTIK
    ================================--}}
    <div class="row mb-4">

        <div class="col-md-6">
            <div class="kpi-card bg-danger">
                <small>Pengunjung Hari Ini</small>
                <h2>{{ $hariIni }}</h2>
                <span>Orang</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="kpi-card bg-dark">
                <small>Pengunjung Bulan Ini</small>
                <h2>{{ $bulanIni }}</h2>
                <span>Orang</span>
            </div>
        </div>

    </div>


    {{-- ===============================
        GRAFIK TAMU PER BULAN
    ================================--}}
    <div class="card border-0 shadow-sm rounded-4 p-4">

        <h6 class="fw-bold mb-3">
            Grafik Kunjungan Tamu Per Bulan
        </h6>

        <canvas id="chart"></canvas>

    </div>

</div>



{{-- ===============================
    CHART JS
===============================--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($labels);
const data   = @json($data);

new Chart(document.getElementById("chart"), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: data,
            backgroundColor: '#E31E24',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { title: { display: true, text: 'Bulan' } },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Jumlah Kunjungan' },
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>



<style>

.kpi-card{
    color:white;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.18);
}

.kpi-card h2{
    font-size:36px;
    font-weight:700;
    margin:5px 0;
}

.kpi-card span{
    font-size:13px;
    opacity:0.85;
}

</style>

@endsection