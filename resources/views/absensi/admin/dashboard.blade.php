@extends('layouts.admin-absensi')

@section('title','Dashboard Admin Absensi')

@section('content')

<div class="container-fluid">

<!-- HEADER -->

<div class="mb-4">
<h4 class="fw-bold mb-1">
<i class="bi bi-speedometer2"></i> Dashboard Admin Absensi
</h4>
<small class="text-muted">
Ringkasan data absensi hari ini
</small>
</div>

<!-- STATISTIK -->

<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body d-flex align-items-center">

<div class="me-3 text-danger fs-1">
<i class="bi bi-people"></i>
</div>

<div>
<div class="text-muted">Total Magang</div>
<h3 class="fw-bold text-danger mb-0">{{ $totalMagang }}</h3>
<small class="text-muted">Peserta magang aktif</small>
</div>

</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body d-flex align-items-center">

<div class="me-3 text-success fs-1">
<i class="bi bi-check-circle"></i>
</div>

<div>
<div class="text-muted">Hadir Hari Ini</div>
<h3 class="fw-bold text-success mb-0">{{ $hadirHariIni }}</h3>
<small class="text-muted">Sudah melakukan presensi</small>
</div>

</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body d-flex align-items-center">

<div class="me-3 text-warning fs-1">
<i class="bi bi-clock-history"></i>
</div>

<div>
<div class="text-muted">Terlambat</div>
<h3 class="fw-bold text-warning mb-0">{{ $terlambat }}</h3>
<small class="text-muted">Datang terlambat</small>
</div>

</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-0 shadow-sm h-100">
<div class="card-body d-flex align-items-center">

<div class="me-3 text-danger fs-1">
<i class="bi bi-x-circle"></i>
</div>

<div>
<div class="text-muted">Belum Presensi</div>
<h3 class="fw-bold text-danger mb-0">{{ $belumPresensi }}</h3>
<small class="text-muted">Belum melakukan presensi</small>
</div>

</div>
</div>
</div>

</div>

<!-- FILTER GRAFIK -->

<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-white fw-semibold">
<i class="bi bi-funnel"></i> Filter Grafik Absensi
</div>

<div class="card-body">

<form method="GET" action="{{ route('absensi.admin.dashboard') }}">

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

<a href="{{ route('absensi.admin.dashboard') }}" class="btn btn-secondary">
Reset
</a>

</div>

</div>

</form>

</div>

</div>

<!-- GRAFIK -->

<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-white fw-semibold">
<i class="bi bi-bar-chart"></i> Grafik Absensi
</div>

<div class="card-body" style="height:350px;">
<canvas id="grafikAbsensi"></canvas>
</div>

</div>

<!-- TABEL ABSENSI HARI INI -->

<div class="card border-0 shadow-sm">

<div class="card-header bg-white fw-semibold">
<i class="bi bi-table"></i> Absensi Hari Ini
</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead class="table-light">

<tr>
<th width="60">No</th>
<th>Nama</th>
<th>Jam Masuk</th>
<th>Jam Pulang</th>
<th>Status</th>
</tr>

</thead>

<tbody>

@forelse($absensiHariIni as $index => $item)

<tr>

<td class="text-center">
{{ $index + 1 }}
</td>

<td>
{{ $item->user->name ?? '-' }}
</td>

<td>
{{ $item->jam_masuk ?? '-' }}
</td>

<td>
{{ $item->jam_pulang ?? '-' }}
</td>

<td>

@if($item->status == 'masuk')
<span class="badge bg-success">Hadir</span>

@elseif($item->status == 'terlambat')
<span class="badge bg-warning text-dark">Terlambat</span>

@else
<span class="badge bg-secondary">{{ $item->status }}</span>
@endif

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-4 text-muted">
Belum ada absensi hari ini
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($bulan);
const data = @json($jumlahAbsensi);

const ctx = document.getElementById('grafikAbsensi');

if(labels.length > 0){

new Chart(ctx,{

type:'line',

data:{
labels:labels,
datasets:[{
label:'Jumlah Kehadiran',
data:data,
borderWidth:3,
borderColor:'#dc3545',
backgroundColor:'rgba(220,53,69,0.15)',
fill:true,
tension:0.4,
pointRadius:5,
pointBackgroundColor:'#dc3545'
}]
},

options:{
responsive:true,
maintainAspectRatio:false,
plugins:{
legend:{display:true}
},
scales:{
y:{
beginAtZero:true,
ticks:{
precision:0,
stepSize:1
}
}
}
}

});

}

</script>

@endsection