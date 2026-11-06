@extends('layouts.pimpinan')

@section('title','Dashboard Pimpinan')

@section('content')

<h3 class="mb-4 text-danger fw-bold">
Dashboard Monitoring
</h3>

<!-- ================= FILTER ================= -->
<div class="card mb-4 shadow-sm">
<div class="card-body">

<form method="GET" class="row g-3">

<div class="col-md-4">
<label>Bulan</label>
<select name="bulan" class="form-select">
<option value="">Semua</option>
@for($i=1;$i<=12;$i++)
<option value="{{ $i }}" {{ $bulan==$i ? 'selected':'' }}>
{{ date('F', mktime(0,0,0,$i,1)) }}
</option>
@endfor
</select>
</div>

<div class="col-md-4">
<label>Tahun</label>
<select name="tahun" class="form-select">
@for($i=date('Y');$i>=2023;$i--)
<option value="{{ $i }}" {{ $tahun==$i ? 'selected':'' }}>
{{ $i }}
</option>
@endfor
</select>
</div>

<div class="col-md-4 d-flex align-items-end">
<button class="btn btn-danger w-100">
Filter Data
</button>
</div>

</form>

</div>
</div>


<!-- ================= STATISTIK ================= -->
<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="card shadow-sm text-center">
<div class="card-body">
<h3 class="text-danger">{{ $totalAdmin }}</h3>
<small>Total Admin</small>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm text-center">
<div class="card-body">
<h3 class="text-primary">{{ $totalAbsensi }}</h3>
<small>Total Absensi</small>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm text-center">
<div class="card-body">
<h3 class="text-success">{{ $totalBarang }}</h3>
<small>Total Barang</small>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm text-center">
<div class="card-body">
<h3 class="text-warning">{{ $barangDipinjam }}</h3>
<small>Barang Dipinjam</small>
</div>
</div>
</div>

</div>


<!-- ================= CHART ================= -->
<div class="row g-4">

<!-- ABSENSI -->
<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">
<h5>Grafik Absensi</h5>
<canvas id="absensiChart"></canvas>
</div>
</div>
</div>

<!-- BARANG -->
<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">
<h5>Status Barang</h5>
<canvas id="barangChart"></canvas>
</div>
</div>
</div>

</div>


<!-- ================= EXPORT ================= -->
<div class="mt-4">
<a href="{{ route('pimpinan.export.pdf') }}"
class="btn btn-dark">
<i class="bi bi-file-earmark-pdf"></i>
Export Laporan PDF
</a>
</div>

@endsection



@section('scripts')
<script>

/*
|--------------------------------------------------------------------------
| ✅ ABSENSI CHART DINAMIS (DATABASE BASED)
|--------------------------------------------------------------------------
*/
const absensiLabels = @json($labelsAbsensi);
const absensiData   = @json($dataAbsensi);

new Chart(document.getElementById('absensiChart'), {
    type:'bar',
    data:{
        labels:absensiLabels,
        datasets:[{
            label:'Status Absensi',
            data:absensiData,
            backgroundColor:[
                '#28a745',
                '#dc3545',
                '#ffc107',
                '#0dcaf0',
                '#6f42c1',
                '#fd7e14'
            ]
        }]
    },
    options:{
        responsive:true,
        cutout:'65%',
        plugins:{
            legend:{
                position:'bottom'
            }
        }
    }
});


/*
|--------------------------------------------------------------------------
| ✅ STATUS BARANG (DATABASE BASED)
|--------------------------------------------------------------------------
*/
new Chart(document.getElementById('barangChart'), {
    type:'bar',
    data:{
        labels:['Tersedia','Dipinjam'],
        datasets:[{
            label:'Status Barang',
            data:[
                {{ $barangTersedia }},
                {{ $barangDipinjam }}
            ],
            backgroundColor:[
                '#0d6efd',
                '#ffc107'
            ]
        }]
    },
    options:{
        responsive:true,
        cutout:'65%',
        plugins:{
            legend:{
                position:'bottom'
            }
        }
    }
});

</script>
@endsection