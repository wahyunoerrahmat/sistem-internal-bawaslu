@extends('layouts.admin-barang')

@section('title','Data Barang')

@section('content')

<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Data Barang
        </h3>

        <div class="d-flex gap-2">
            <a href="{{ route('barang.admin.barang.export') }}"
               class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </a>

            <a href="{{ route('barang.admin.barang.pilih') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Tambah Barang
            </a>
        </div>
    </div>


    <!-- ================= CARD ================= -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <!-- ================= FILTER ================= -->
            <form method="GET" class="row g-2 mb-4">

                <div class="col-md-5">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari jenis, kode, atau merk..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>

                        <option value="tersedia"
                            {{ request('status')=='tersedia'?'selected':'' }}>
                            Tersedia
                        </option>

                        <option value="dipinjam"
                            {{ request('status')=='dipinjam'?'selected':'' }}>
                            Dipinjam
                        </option>
                    </select>
                </div>

                <div class="col-md-auto">
                    <button class="btn btn-danger">
                        <i class="bi bi-funnel"></i> Filter
                    </button>

                    <a href="{{ route('barang.admin.barang.index') }}"
                       class="btn btn-warning text-white">
                        Reset
                    </a>
                </div>

            </form>


            <!-- ================= TABLE ================= -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Jenis Barang</th>
                            <th>NUP</th>
                            <th>Merk</th>
                            <th>Tipe</th>
                            <th>Kondisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($data as $item)
                        <tr>

                            <td class="text-center">
                                {{ $item->no_urut }}
                            </td>

                            <td>{{ $item->jenis_barang }}</td>
                            <td>{{ $item->nup }}</td>
                            <td>{{ $item->merk ?? '-' }}</td>
                            <td>{{ $item->tipe ?? '-' }}</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($item->kondisi) }}
                                </span>
                            </td>

                            <!-- ✅ STATUS DINAMIS -->
                            <td class="text-center">
                                @if($item->status == 'tersedia')

                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i>
                                        Tersedia
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Dipinjam
                                    </span>

                                @endif
                            </td>


                            <!-- ✅ AKSI PROFESIONAL -->
                            <td class="text-center">

                                @if($item->status == 'tersedia')

                                    <a href="{{ route('barang.admin.barang.edit',$item->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('barang.admin.barang.destroy',$item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                @else

                                    <span class="badge bg-secondary">
                                        Sedang Dipinjam
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="9"
                                class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3"></i>
                                <br>
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection