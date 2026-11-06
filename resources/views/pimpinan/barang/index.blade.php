@extends('layouts.pimpinan')

@section('title', 'Data Barang')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-1">
            <i class="bi bi-box-seam"></i> Data Barang
        </h4>
        <p class="text-muted mb-0">
            Daftar seluruh data barang.
        </p>
    </div>

    <!-- Filter Section (Optional jika ingin tambah filter nanti) -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="">
                <div class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select">
                            <option value="">Semua</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-funnel-fill"></i> Filter Data
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Barang</th>
                            <th>NUP</th>
                            <th>Merk</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $barang->jenis_barang }}
                            </td>

                            <td>
                                {{ $barang->nup }}
                            </td>

                            <td>
                                {{ $barang->merk ?? '-' }}
                            </td>

                            <td>
                                @if($barang->kondisi === 'baik')
                                    <span class="badge bg-success">
                                        Baik
                                    </span>
                                @elseif($barang->kondisi === 'rusak')
                                    <span class="badge bg-danger">
                                        Rusak
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($barang->kondisi) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($barang->status === 'tersedia')
                                    <span class="badge bg-primary">
                                        Tersedia
                                    </span>
                                @elseif($barang->status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($barang->status) }}
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle"></i>
                                Belum ada data barang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $barangs->links() }}
            </div>

        </div>
    </div>

</div>

@endsection