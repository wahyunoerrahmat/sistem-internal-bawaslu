@extends('layouts.pimpinan')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="title">Dashboard Pegawai</div>

<div class="cards">

    <!-- WFO -->
    <div class="card center">
        <h3>WFO</h3>
        <p>Absen kerja dari kantor</p>

        <a href="{{ route('absensi.pegawai.masuk.form') }}" class="btn">
            Absen Masuk
        </a>

        @if($bolehPulang)
            <a href="{{ route('absensi.pegawai.pulang.form') }}"
               class="btn"
               style="margin-top:8px;">
                Absen Pulang
            </a>
        @else
            <button class="btn"
                    style="margin-top:8px; background:#999; cursor:not-allowed;"
                    disabled>
                Absen Pulang
            </button>
        @endif
    </div>

    <!-- WFH -->
    <div class="card center">
        <h3>WFH</h3>
        <p>Absen kerja dari luar kantor</p>

        <a href="{{ route('absensi.pegawai.wfh.masuk.form') }}" class="btn">
            Absen Masuk
        </a>

        <a href="{{ route('absensi.pegawai.wfh.pulang.form') }}"
           class="btn"
           style="margin-top:8px;">
            Absen Pulang
        </a>
    </div>

    <!-- Riwayat -->
    <div class="card center">
        <h3>Riwayat Absensi</h3>
        <p>Lihat riwayat kehadiran</p>

        <a href="{{ route('absensi.pegawai.riwayat') }}" class="btn">
            Lihat
        </a>
    </div>

</div>
@endsection
