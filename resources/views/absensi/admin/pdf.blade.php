<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Absensi</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.logo{
    width:70px;
}

.title{
    font-size:18px;
    font-weight:bold;
    margin-top:5px;
}

.sub{
    font-size:12px;
}

.table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.table th{
    background:#f2f2f2;
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

.table td{
    border:1px solid #000;
    padding:6px;
}

.center{
    text-align:center;
}

.small{
    font-size:10px;
    color:#555;
}

.status{
    font-weight:bold;
}

.foto{
    width:60px;
}

</style>

</head>

<body>


<!-- HEADER -->
<div class="header">

    <img src="{{ public_path('images/logo-bawaslu.png') }}" class="logo">

    <div class="title">
        SISTEM INTERNAL BAWASLU KABUPATEN BOGOR
    </div>

    <div class="sub">
        Laporan Absensi Magang
    </div>

    <div class="small">
        Dicetak: {{ now()->format('d M Y H:i') }}
    </div>

</div>


<table class="table">

<tr>
<th width="40">No</th>
<th>Nama</th>
<th width="110">Tanggal</th>
<th width="90">Jam Masuk</th>
<th width="90">Jam Pulang</th>
<th width="90">Foto Masuk</th>
<th width="90">Foto Pulang</th>
<th width="100">Status</th>
</tr>


@foreach($data as $i => $item)

<tr>

<td class="center">
{{ $i+1 }}
</td>


<td>
{{ optional($item->user)->name ?? '-' }}
</td>


<td class="center">
@if($item->tanggal)
{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
@else
-
@endif
</td>


<td class="center">
@if($item->jam_masuk)
{{ $item->jam_masuk }}
@else
-
@endif
</td>


<td class="center">
@if($item->jam_pulang)
{{ $item->jam_pulang }}
@else
-
@endif
</td>


<!-- FOTO MASUK -->
<td class="center">

@if($item->foto_masuk)
<img src="{{ public_path('storage/'.$item->foto_masuk) }}" class="foto">
@else
-
@endif

</td>


<!-- FOTO PULANG -->
<td class="center">

@if($item->foto_pulang)
<img src="{{ public_path('storage/'.$item->foto_pulang) }}" class="foto">
@else
-
@endif

</td>


<td class="center status">

@if($item->status == 'masuk')
Masuk
@elseif($item->status == 'terlambat')
Terlambat
@elseif($item->status == 'pulang')
Pulang
@else
{{ ucfirst($item->status) }}
@endif

</td>

</tr>

@endforeach


</table>



<br><br><br>


<table width="100%">

<tr>

<td width="60%"></td>

<td class="center">

Bogor, {{ now()->format('d M Y') }}

<br><br>

Mengetahui,

<br><br><br><br>

_________________________

<br>

Admin Absensi

</td>

</tr>

</table>


</body>
</html>