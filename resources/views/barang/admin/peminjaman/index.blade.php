@extends('layouts.admin-barang')

@section('title','Peminjaman Barang')

@section('content')

<div class="container-fluid">

    <!-- ================= TITLE ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-danger mb-0">
            <i class="bi bi-arrow-left-right me-2"></i>
            Peminjaman Barang
        </h3>
    </div>


    <!-- ================= ALERT ================= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- ================= CARD ================= -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th class="text-center">Foto Pinjam</th>
                            <th class="text-center">Foto Kembali</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($data as $item)

                        <tr>

                            <!-- ================= BARANG ================= -->
                            <td>
                                <strong>
                                    {{ $item->barang->jenis_barang ?? '-' }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    {{ $item->barang->nup ?? '-' }}
                                </small>
                            </td>


                            <!-- ================= PEMINJAM ================= -->
                            <td>
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $item->user->name ?? '-' }}
                            </td>


                            <!-- ================= TANGGAL PINJAM ================= -->
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                            </td>


                            <!-- ================= RENCANA KEMBALI ================= -->
                            <td>
                                {{ $item->tanggal_kembali_rencana
                                    ? \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->format('d M Y')
                                    : '-' }}
                            </td>


                            <!-- ================= FOTO PINJAM ================= -->
                            <td class="text-center">

                                @if($item->foto_kondisi_pinjam)

                                    <img src="{{ asset('storage/'.$item->foto_kondisi_pinjam) }}"
                                         width="60"
                                         class="rounded border preview-foto"
                                         style="cursor:pointer"
                                         data-foto="{{ asset('storage/'.$item->foto_kondisi_pinjam) }}">

                                @else
                                    <span class="text-muted">-</span>
                                @endif

                            </td>


                            <!-- ================= FOTO KEMBALI ================= -->
                            <td class="text-center">

                                @if($item->foto_kondisi_kembali)

                                    <img src="{{ asset('storage/'.$item->foto_kondisi_kembali) }}"
                                         width="60"
                                         class="rounded border preview-foto"
                                         style="cursor:pointer"
                                         data-foto="{{ asset('storage/'.$item->foto_kondisi_kembali) }}">

                                @else
                                    <span class="text-muted">-</span>
                                @endif

                            </td>


                            <!-- ================= STATUS ================= -->
                            <td>

                                @if($item->status == 'dipinjam')

                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i>
                                        Dipinjam
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i>
                                        Dikembalikan
                                    </span>

                                @endif

                            </td>


                            <!-- ================= AKSI ================= -->
                            <td class="text-center">

                                @if($item->status == 'dipinjam')

                                    <form method="POST"
                                          action="{{ route('barang.admin.peminjaman.kembali',$item->id) }}"
                                          enctype="multipart/form-data"
                                          onsubmit="return confirm('Kembalikan barang ini?')">

                                        @csrf

                                        <input type="file"
                                               name="foto_kondisi_kembali"
                                               class="form-control mb-2"
                                               required>

                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                            Kembalikan
                                        </button>

                                    </form>

                                @else

                                    <span class="badge bg-secondary">
                                        Selesai
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">

                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                Belum ada data peminjaman

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>


<!-- ================= MODAL PREVIEW FOTO ================= -->
<div class="modal fade" id="previewFotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Preview Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img id="previewFoto" src="" class="img-fluid rounded">
            </div>

        </div>
    </div>
</div>


<script>

document.addEventListener("click", function(e){

    if(e.target.classList.contains("preview-foto")){

        let src = e.target.getAttribute("data-foto");

        document.getElementById("previewFoto").src = src;

        let modal = new bootstrap.Modal(
            document.getElementById("previewFotoModal")
        );

        modal.show();
    }

});

</script>

@endsection