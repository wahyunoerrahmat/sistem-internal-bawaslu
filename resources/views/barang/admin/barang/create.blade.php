@extends('layouts.admin-barang')

@section('title','Tambah Barang')

@section('content')

<!-- PAGE HEADER -->
<div class="page-header">

    <div style="display:flex;align-items:center;gap:15px;">

        <div class="header-icon">
            <i class="bi bi-box-seam"></i>
        </div>

        <div>
            <h2 class="header-title">Tambah Barang</h2>
            <p class="header-subtitle">
                Tambahkan data inventaris barang baru ke dalam sistem
            </p>
        </div>

    </div>

</div>



<!-- FORM CARD -->
<div class="card form-card">

<form method="POST" action="{{ route('barang.admin.barang.store') }}">

@csrf


<div class="form-grid">

    <!-- NO URUT -->
    <div class="form-group">
        <label>No Urut</label>
        <input type="text"
               name="no_urut"
               class="form-control"
               placeholder="Masukkan nomor urut"
               required>
    </div>


    <!-- JENIS BARANG -->
    <div class="form-group">
        <label>Jenis Barang</label>
        <input type="text"
               name="jenis_barang"
               class="form-control"
               placeholder="Contoh: Kamera"
               required>
    </div>


    <!-- NUP -->
    <div class="form-group">
        <label>NUP</label>
        <input type="text"
               name="nup"
               class="form-control"
               placeholder="Masukkan kode NUP"
               required>
    </div>


    <!-- MERK -->
    <div class="form-group">
        <label>Merk</label>
        <input type="text"
               name="merk"
               class="form-control"
               placeholder="Contoh: Canon">
    </div>


    <!-- TIPE -->
    <div class="form-group">
        <label>Tipe</label>
        <input type="text"
               name="tipe"
               class="form-control"
               placeholder="Contoh: Kamera Digital">
    </div>


    <!-- KONDISI -->
    <div class="form-group">
        <label>Kondisi</label>
        <select name="kondisi" class="form-select">

            <option value="baik">Baik</option>
            <option value="rusak ringan">Rusak Ringan</option>
            <option value="rusak berat">Rusak Berat</option>

        </select>
    </div>


    <!-- STATUS -->
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-select">

            <option value="tersedia">Tersedia</option>
            <option value="dipinjam">Dipinjam</option>

        </select>
    </div>

</div>



<!-- BUTTON -->
<div class="form-button">

<button class="btn btn-success btn-action">
<i class="bi bi-check-circle"></i>
Simpan
</button>

<a href="{{ route('barang.admin.barang.index') }}"
   class="btn btn-secondary btn-action">

<i class="bi bi-arrow-left"></i>
Batal

</a>

</div>

</form>

</div>



<style>

/* FORM CARD */

.form-card{
padding:35px;
max-width:1000px;
}


/* GRID */

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}


/* FORM GROUP */

.form-group{
display:flex;
flex-direction:column;
gap:6px;
}

.form-group label{
font-weight:600;
font-size:14px;
}


/* INPUT */

.form-control,
.form-select{
padding:9px;
border-radius:6px;
border:1px solid #ddd;
}


/* BUTTON */

.form-button{
margin-top:30px;
display:flex;
gap:12px;
}

.btn-action{
display:flex;
align-items:center;
gap:6px;
padding:9px 16px;
border-radius:8px;
}


/* RESPONSIVE */

@media(max-width:768px){

.form-grid{
grid-template-columns:1fr;
}

}

</style>

@endsection