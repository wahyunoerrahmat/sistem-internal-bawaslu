@extends('layouts.pegawai')

@section('title','Dashboard Pegawai')

@section('content')

<div class="container-fluid">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="bi bi-speedometer2"></i> Dashboard Barang
        </h4>
        <small class="text-muted">
            Monitoring inventaris dan aktivitas peminjaman barang
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
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="icon-box bg-danger text-white me-3">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>
                    <div class="text-muted">Total Barang</div>
                    <h3 class="fw-bold mb-0">{{ $totalBarang ?? 0 }}</h3>
                </div>

            </div>

        </div>
    </div>


    <!-- BARANG TERSEDIA -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="icon-box bg-success text-white me-3">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div>
                    <div class="text-muted">Barang Tersedia</div>
                    <h3 class="fw-bold mb-0">{{ $tersedia ?? 0 }}</h3>
                </div>

            </div>

        </div>
    </div>


    <!-- BARANG DIPINJAM -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="icon-box bg-warning text-white me-3">
                    <i class="bi bi-arrow-left-right"></i>
                </div>

                <div>
                    <div class="text-muted">Barang Dipinjam</div>
                    <h3 class="fw-bold mb-0">{{ $dipinjam ?? 0 }}</h3>
                </div>

            </div>

        </div>
    </div>


    <!-- PEMINJAMAN SAYA -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="icon-box bg-primary text-white me-3">
                    <i class="bi bi-person-check"></i>
                </div>

                <div>
                    <div class="text-muted">Peminjaman Saya</div>
                    <h3 class="fw-bold mb-0">{{ $peminjamanSaya ?? 0 }}</h3>
                </div>

            </div>

        </div>
    </div>

</div>


<!-- GRAFIK -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-bar-chart"></i> Grafik Aktivitas Peminjaman
    </div>

    <div class="card-body" style="height:350px">
        <canvas id="grafikBarang"></canvas>
    </div>

</div>

</div>

<!-- CHART JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = {!! json_encode($labels ?? []) !!};
const data = {!! json_encode($data ?? []) !!};

const ctx = document.getElementById('grafikBarang');

if(labels.length > 0){

    new Chart(ctx,{

        type:'line',

        data:{
            labels:labels,
            datasets:[{
                label:'Aktivitas Peminjaman',
                data:data,
                borderColor:'#dc3545',
                backgroundColor:'rgba(220,53,69,0.15)',
                borderWidth:3,
                fill:true,
                tension:0.4
            }]
        },

        options:{
            responsive:true,

            plugins:{
                legend:{
                    display:true
                }
            },

            scales:{
                y:{
                    beginAtZero:true
                }
            }
        }

    });

}

</script>

<style>

.icon-box{
    width:50px;
    height:50px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    font-size:22px;
}

</style>

@endsection
