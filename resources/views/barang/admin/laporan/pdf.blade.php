<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Peminjaman Barang</title>

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
    width:70px;
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
        Laporan Peminjaman Barang
    </div>

    <div class="small">
        Dicetak: {{ now()->format('d M Y H:i') }}
    </div>

</div>


<table class="table">

<tr>
<th width="40">No</th>
<th>Nama Barang</th>
<th>Peminjam</th>
<th width="110">Tanggal Pinjam</th>
<th width="110">Tanggal Kembali</th>
<th width="90">Foto Pinjam</th>
<th width="90">Foto Kembali</th>
<th width="100">Status</th>
</tr>


@foreach($laporan as $i => $item)

<tr>

<td class="center">
{{ $i+1 }}
</td>


<td>

<strong>
{{ optional($item->barang)->jenis_barang ?? '-' }}
</strong>

<br>

<span class="small">
{{ optional($item->barang)->nup ?? '-' }}
</span>

</td>


<td>
{{ optional($item->user)->name ?? '-' }}
</td>


<td class="center">

@if($item->tanggal_pinjam)
{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
@else
-
@endif

</td>


<td class="center">

@if($item->tanggal_kembali_real)
{{ \Carbon\Carbon::parse($item->tanggal_kembali_real)->format('d M Y') }}
@else
-
@endif

</td>


<!-- FOTO PINJAM -->
<td class="center">

@if($item->foto_kondisi_pinjam)

<img src="{{ public_path('storage/'.$item->foto_kondisi_pinjam) }}" class="foto">

@else
-
@endif

</td>


<!-- FOTO KEMBALI -->
<td class="center">

@if($item->foto_kondisi_kembali)

<img src="{{ public_path('storage/'.$item->foto_kondisi_kembali) }}" class="foto">

@else
-
@endif

</td>


<td class="center status">

@if($item->status == 'dipinjam')
Dipinjam
@else
Dikembalikan
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

Admin Barang

</td>

</tr>

</table>


</body>
</html>