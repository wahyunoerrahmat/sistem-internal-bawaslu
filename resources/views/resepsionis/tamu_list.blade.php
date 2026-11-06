@extends('layouts.resepsionis')

@section('title','Data Buku Tamu')

@section('content')

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="fw-bold text-danger mb-0">
            <i class="fa fa-address-book me-2"></i>
            Data Buku Tamu
        </h5>

        <div>
            <a href="{{ route('resepsionis.dashboard') }}" class="btn btn-secondary me-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>

            <a href="{{ route('resepsionis.tamu.create') }}" class="btn btn-danger">
                <i class="fa fa-plus"></i> Input Tamu
            </a>
        </div>

    </div>

    {{-- Filter Download --}}
    <div class="mb-3">
        <form action="{{ route('resepsionis.tamu.download') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="date" name="start" class="form-control" required>
            </div>
            <div class="col-auto">
                <input type="date" name="end" class="form-control" required>
            </div>
            <div class="col-auto">
                <button type="submit" name="format" value="excel" class="btn btn-success me-1">
                    <i class="fa fa-file-excel me-1"></i> Download Excel
                </button>
                <button type="submit" name="format" value="pdf" class="btn btn-danger">
                    <i class="fa fa-file-pdf me-1"></i> Download PDF
                </button>
            </div>
        </form>
    </div>

    <div class="mb-2">

        <small class="text-muted">
            Total Data :
            <b>{{ $tamus->count() }}</b>
        </small>

        <input type="text"
               id="searchTamu"
               class="form-control form-control-sm w-auto d-inline float-end"
               placeholder="Cari data...">

    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-tamu align-middle text-center" id="tabelTamu">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Keperluan</th>
                            <th>Pihak Dituju</th>
                            <th>Penerima</th>
                            <th>Dokumentasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($tamus as $t)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-start">
                                {{ $t->nama_lengkap }}
                            </td>

                            <td>
                                <span class="badge instansi">
                                    {{ $t->alamat }}
                                </span>
                            </td>

                            <td>{{ $t->kontak }}</td>

                            <td>
                                <span class="badge keperluan">
                                    {{ $t->keperluan }}
                                </span>
                            </td>

                            <td>{{ $t->pihak_dituju }}</td>

                            <td>{{ $t->nama_penerima ?? '-' }}</td>

                            <td>

                                @if($t->dokumentasi)

                                <div class="d-flex flex-column gap-1">

                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        onclick="showImage(`{{ asset('storage/'.$t->dokumentasi) }}`)">
                                        <i class="fa fa-eye"></i> Lihat
                                    </button>

                                    <a href="{{ asset('storage/'.$t->dokumentasi) }}"
                                       download
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-download"></i> Download
                                    </a>

                                </div>

                                @else

                                <span class="text-muted small">
                                    Tidak Ada
                                </span>

                                @endif

                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($t->waktu_datang)->format('d M Y - H:i') }}
                            </td>

                            <td>

                                <a href="{{ route('resepsionis.tamu.edit',$t->id) }}"
                                   class="btn btn-sm btn-warning text-white me-1">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('resepsionis.tamu.destroy',$t->id) }}"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirmDelete()">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-5">
                                Tidak ada data tamu
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

{{-- Modal Dokumentasi --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <h6 class="modal-title">Dokumentasi Tamu</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid rounded">
            </div>

        </div>
    </div>
</div>

<script>

document.getElementById("searchTamu")
.addEventListener("keyup", function(){

    let val = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tabelTamu tbody tr");

    rows.forEach(row=>{
        row.style.display =
        row.innerText.toLowerCase().includes(val) ? "" : "none";
    });

});

function confirmDelete(){
    return confirm("Data akan dihapus permanen!");
}

function showImage(src){
    document.getElementById("modalImage").src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}

</script>

<style>

.table-tamu{
    border-collapse:separate;
    border-spacing:0 6px;
}

.table-tamu tbody tr{
    background:white;
    box-shadow:0 1px 6px rgba(0,0,0,0.05);
}

.table-tamu td{
    border:none;
    padding:10px 12px;
}

.badge.instansi{
    background:#e9ecef;
    color:#333;
    padding:5px 10px;
    border-radius:6px;
}

.badge.keperluan{
    background:#f8d7da;
    color:#842029;
    padding:5px 10px;
    border-radius:6px;
}

</style>

@endsection