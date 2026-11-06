@extends('layouts.admin-barang')

@section('title','Import Data Barang')

@section('content')

<div class="title">
    <i class="bi bi-upload me-2"></i>
    Import Data Barang
</div>

<div class="card import-card">

    <form method="POST"
          action="{{ route('barang.admin.barang.import') }}"
          enctype="multipart/form-data">

        @csrf

        <!-- FILE UPLOAD -->
        <div class="form-group">

            <label class="form-label">
                <i class="bi bi-file-earmark-arrow-up"></i>
                Pilih File (CSV / Excel)
            </label>

            <div class="upload-box">

                <input type="file"
                       name="file"
                       accept=".csv,.xlsx,.xls"
                       required>

            </div>

            <small class="text-muted">
                Format yang diperbolehkan: CSV, XLSX, XLS
            </small>

        </div>


        <!-- CONTOH CSV -->
        <div class="sample-box">

            <div class="sample-title">
                <i class="bi bi-info-circle"></i>
                Contoh isi file CSV
            </div>

<pre>
no_urut,jenis_barang,nup,nama_barang,merk,tipe
1,Laptop,3020104001,1,Laptop Asus,Asus,VivoBook
2,Printer,3020104002,1,Printer Epson,Epson,L3110
</pre>

        </div>


        <!-- BUTTON -->
        <div class="button-group">

            <button class="btn btn-success">
                <i class="bi bi-cloud-upload"></i>
                Import Data
            </button>

            <a href="{{ route('barang.admin.barang.index') }}"
               class="btn btn-warning">

               <i class="bi bi-arrow-left"></i>
               Kembali

            </a>

        </div>

    </form>

</div>


<style>

/* CARD */

.import-card{
padding:35px;
max-width:900px;
}


/* FORM */

.form-group{
margin-bottom:30px;
}

.form-label{
font-weight:600;
margin-bottom:10px;
display:block;
}


/* UPLOAD BOX */

.upload-box{
border:2px dashed #ddd;
padding:35px;
border-radius:10px;
background:#fafafa;
text-align:center;
transition:0.25s;
}

.upload-box:hover{
border-color:#c40000;
background:#fff5f5;
}

.upload-box input{
border:none;
background:none;
font-size:15px;
}


/* SAMPLE CSV */

.sample-box{
margin-top:20px;
background:#f8f9fa;
padding:20px;
border-radius:8px;
border:1px solid #eee;
}

.sample-title{
font-weight:600;
margin-bottom:10px;
color:#444;
}

.sample-box pre{
margin:0;
font-size:13px;
}


/* BUTTON */

.button-group{
margin-top:30px;
display:flex;
gap:15px;
}

.btn-success{
background:#198754;
color:white;
border:none;
padding:10px 18px;
}

.btn-success:hover{
background:#157347;
}

.btn-warning{
background:#f4b400;
color:black;
border:none;
padding:10px 18px;
}

</style>

@endsection