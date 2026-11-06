@extends('layouts.pegawai')

@section('title','Peminjaman Barang')

@section('content')

<div class="container-fluid">

    <!-- ================= TITLE ================= -->
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Daftar Barang Tersedia
        </h3>
    </div>


    <!-- ================= ALERT SUCCESS ================= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- ================= ALERT ERROR ================= -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- ================= ALERT DATA KOSONG ================= -->
    @if($barang->isEmpty())
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Barang tidak tersedia.
        </div>
    @endif


    <!-- ================= TABLE ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Jenis Barang</th>
                            <th>NUP</th>
                            <th>Merk</th>
                            <th width="120">Jumlah</th>
                            <th width="200">Foto Kondisi</th>
                            <th>Status</th>
                            <th class="text-center" width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($barang as $index => $item)

                        <tr>

                            <form action="{{ route('pegawai.barang.pinjam',$item->id) }}"
                                  method="POST"
                                  enctype="multipart/form-data"
                                  onsubmit="return confirm('Apakah yakin ingin meminjam barang ini?')">

                            @csrf

                            <td>{{ $index + 1 }}</td>

                            <td>{{ $item->jenis_barang ?? '-' }}</td>
                            <td>{{ $item->nup ?? '-' }}</td>
                            <td>{{ $item->merk ?? '-' }}</td>


                            <!-- JUMLAH -->
                            <td>
                                <input type="number"
                                       name="jumlah"
                                       class="form-control"
                                       min="1"
                                       value="1"
                                       required>
                            </td>


                            <!-- FOTO KONDISI -->
                            <td>
                                <input type="file"
                                       name="foto_kondisi_pinjam"
                                       class="form-control"
                                       required>
                            </td>


                            <td>
                                <span class="badge bg-success">
                                    Tersedia
                                </span>
                            </td>


                            <td class="text-center">

                                <button type="submit"
                                        class="btn btn-danger btn-sm">
                                    <i class="bi bi-box-arrow-up"></i>
                                    Pinjam
                                </button>

                            </td>

                            </form>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8"
                                class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3"></i>
                                <br>
                                Tidak ada data barang tersedia
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