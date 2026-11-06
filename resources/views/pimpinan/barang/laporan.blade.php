@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4 text-danger fw-bold">Laporan Peminjaman Barang</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @if ($item->status == 'dipinjam')
                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
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
