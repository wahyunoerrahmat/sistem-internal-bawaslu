<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>Laporan Buku Tamu</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
}

.container{
    width:100%;
}

.logo{
    text-align:center;
    margin-bottom:10px;
}

.logo img{
    width:110px;
}

.judul{
    text-align:center;
    font-size:18px;
    font-weight:bold;
    margin-bottom:4px;
}

.subjudul{
    text-align:center;
    font-size:12px;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

th, td{
    border:1px solid #333;
    padding:6px;
    word-wrap:break-word;
}

th{
    background:#f2f2f2;
    text-align:center;
}

.text-center{
    text-align:center;
}

.ttd{
    margin-top:40px;
    width:250px;
    float:right;
    text-align:center;
}

</style>

</head>

<body>

<div class="container">

<div class="logo">
<img src="{{ public_path('images/logo-bawaslu.png') }}">
</div>

<div class="judul">
Laporan Data Buku Tamu
</div>

<div class="subjudul">
Sistem Internal Bawaslu Kabupaten Bogor
<br>
Dicetak: {{ date('d M Y H:i') }}
</div>

<table>

<tr>
<th width="5%">No</th>
<th width="15%">Nama</th>
<th width="18%">Alamat</th>
<th width="18%">Kontak</th>
<th width="15%">Keperluan</th>
<th width="10%">Pihak Dituju</th>
<th width="12%">Penerima</th>
<th width="12%">Tanggal</th>
</tr>

@foreach($tamus as $i => $t)

<tr>

<td class="text-center">
{{ $i+1 }}
</td>

<td>
{{ $t->nama_lengkap }}
</td>

<td>
{{ $t->alamat }}
</td>

<td>
{{ $t->kontak }}
</td>

<td>
{{ $t->keperluan }}
</td>

<td>
{{ $t->pihak_dituju }}
</td>

<td>
{{ $t->nama_penerima }}
</td>

<td class="text-center">
{{ \Carbon\Carbon::parse($t->waktu_datang)->format('d M Y') }}
</td>

</tr>

@endforeach

</table>

<div class="ttd">

Bogor, {{ now()->format('d M Y') }}

<br><br>

Mengetahui,

<br><br><br>

---

<br>

Resepsionis

</div>

</div>

</body>
</html>
