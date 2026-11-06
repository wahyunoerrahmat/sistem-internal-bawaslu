@extends('layouts.pegawai')

@section('title','Laporan Peminjaman')

@section('content')

<div class="container-fluid">

<h3 class="fw-bold mb-4">
<i class="bi bi-journal-text"></i> Laporan Peminjaman Saya
</h3>


<div class="card border-0 shadow-sm">

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead class="table-light">

<tr>
<th>No</th>
<th>Barang</th>
<th>NUP</th>
<th>Merk</th>
<th>Tanggal Pinjam</th>
<th>Rencana Kembali</th>
<th>Status</th>
</tr>

</thead>

<tbody>

@forelse($peminjaman as $index => $item)

<tr>

<td>{{ $index+1 }}</td>

<td>{{ $item->barang->jenis_barang ?? '-' }}</td>

<td>{{ $item->barang->nup ?? '-' }}</td>

<td>{{ $item->barang->merk ?? '-' }}</td>

<td>{{ $item->tanggal_pinjam }}</td>

<td>{{ $item->tanggal_kembali_rencana }}</td>

<td>

@if($item->status == 'dipinjam')

<span class="badge bg-warning">
Dipinjam
</span>

@elseif($item->status == 'dikembalikan')

<span class="badge bg-success">
Dikembalikan
</span>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center py-4 text-muted">
Belum ada data peminjaman
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection