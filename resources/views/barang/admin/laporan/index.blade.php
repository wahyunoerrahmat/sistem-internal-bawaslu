@extends('layouts.admin-barang')

@section('title','Laporan Peminjaman')

@section('content')

<div class="container-fluid">

    <h3 class="fw-bold text-danger mb-4">
        <i class="bi bi-file-earmark-text me-2"></i>
        Laporan Peminjaman Barang
    </h3>


    <!-- FILTER LAPORAN -->
    <form method="GET" class="row mb-4 g-3">

        <div class="col-md-3">
            <label class="form-label">Tanggal Mulai</label>
            <input
                type="date"
                name="start"
                value="{{ request('start') }}"
                class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal Akhir</label>
            <input
                type="date"
                name="end"
                value="{{ request('end') }}"
                class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Pilih Pegawai</label>

            <select name="user_id" class="form-select">

                <option value="">Semua Pegawai</option>

                @foreach($users as $user)
                    <option
                        value="{{ $user->id }}"
                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach

            </select>
        </div>


        <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search"></i>
            </button>
        </div>


        <div class="col-md-2 d-flex align-items-end">
            <a
                href="{{ route('barang.admin.laporan.pdf', request()->query()) }}"
                class="btn btn-danger w-100">

                <i class="bi bi-file-earmark-pdf"></i>
                Export PDF

            </a>
        </div>

    </form>



    <!-- TABLE LAPORAN -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Barang</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th class="text-center">Foto Pinjam</th>
                            <th class="text-center">Foto Kembali</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($laporan as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>
                                    {{ optional($item->barang)->jenis_barang ?? '-' }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    {{ optional($item->barang)->nup ?? '-' }}
                                </small>
                            </td>


                            <td>
                                <i class="bi bi-person-circle me-1"></i>
                                {{ optional($item->user)->name ?? '-' }}
                            </td>


                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)
                                    ->translatedFormat('d M Y | H:i') }}
                            </td>


                            <td>

                                @if($item->tanggal_kembali_real)

                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali_real)
                                        ->translatedFormat('d M Y | H:i') }}

                                @else
                                    -
                                @endif

                            </td>



                            <td class="text-center">

                                @if($item->foto_kondisi_pinjam)

                                    <img
                                        src="{{ asset('storage/'.$item->foto_kondisi_pinjam) }}"
                                        width="60"
                                        class="rounded border preview-foto"
                                        style="cursor:pointer"
                                        data-foto="{{ asset('storage/'.$item->foto_kondisi_pinjam) }}">

                                @else
                                    -
                                @endif

                            </td>



                            <td class="text-center">

                                @if($item->foto_kondisi_kembali)

                                    <img
                                        src="{{ asset('storage/'.$item->foto_kondisi_kembali) }}"
                                        width="60"
                                        class="rounded border preview-foto"
                                        style="cursor:pointer"
                                        data-foto="{{ asset('storage/'.$item->foto_kondisi_kembali) }}">

                                @else
                                    -
                                @endif

                            </td>



                            <td>

                                @if($item->status == 'dipinjam')

                                    <span class="badge bg-danger">
                                        Dipinjam
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>

                                @endif

                            </td>



                            <td>

                                @if($item->status == 'dipinjam')

                                    <span class="text-warning fw-semibold">
                                        Sedang digunakan
                                    </span>

                                @else

                                    <span class="text-success fw-semibold">
                                        Selesai
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">

                                <i class="bi bi-inbox fs-2"></i>
                                <br>

                                Belum ada laporan peminjaman

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>



<!-- MODAL PREVIEW FOTO -->
<div class="modal fade" id="previewFotoModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Preview Foto
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <img
                    id="previewFoto"
                    src=""
                    class="img-fluid rounded">

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