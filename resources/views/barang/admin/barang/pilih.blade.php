@extends('layouts.admin-barang')

@section('title','Pilih Metode Tambah Barang')

@section('content')

<div class="title">
    <i class="bi bi-box-seam me-2"></i>
    Tambah Barang
</div>

<div class="card method-wrapper">

    <h3 class="method-title">
        Pilih Metode Input
    </h3>

    <p class="method-subtitle">
        Silakan pilih cara menambahkan data barang ke dalam sistem
    </p>

    <div class="method-container">

        <!-- INPUT MANUAL -->
        <a href="{{ route('barang.admin.barang.create') }}" class="method-card">

            <div class="method-icon manual">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div class="method-text">
                <h4>Input Manual</h4>
                <p>Tambahkan barang satu per satu melalui form input</p>
            </div>

        </a>


        <!-- IMPORT CSV -->
        <a href="{{ route('barang.admin.barang.import.form') }}" class="method-card">

            <div class="method-icon csv">
                <i class="bi bi-file-earmark-arrow-up"></i>
            </div>

            <div class="method-text">
                <h4>Import CSV</h4>
                <p>Upload banyak data barang sekaligus menggunakan file CSV</p>
            </div>

        </a>

    </div>


    <!-- BACK BUTTON -->
    <div class="method-back">

        <a href="{{ route('barang.admin.barang.index') }}"
           class="btn"
           style="background:#6c757d; padding:10px 20px;">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Data Barang

        </a>

    </div>

</div>



<style>

/* WRAPPER */

.method-wrapper{
text-align:center;
padding:40px 20px;
}


/* TITLE */

.method-title{
font-weight:600;
margin-bottom:5px;
}

.method-subtitle{
color:#666;
margin-bottom:30px;
}


/* CONTAINER */

.method-container{
display:flex;
justify-content:center;
gap:25px;
flex-wrap:wrap;
}


/* CARD */

.method-card{
display:flex;
align-items:center;
gap:15px;
width:320px;
padding:20px;
border-radius:10px;
border:1px solid #eee;
text-decoration:none;
color:#333;
background:white;
transition:all 0.25s ease;
}

.method-card:hover{
transform:translateY(-4px);
box-shadow:0 8px 20px rgba(0,0,0,0.12);
border-color:#c40000;
color:#c40000;
}


/* ICON */

.method-icon{
width:55px;
height:55px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
font-size:24px;
color:white;
}

.manual{
background:#0d6efd;
}

.csv{
background:#f4b400;
}


/* TEXT */

.method-text h4{
margin:0;
font-size:18px;
}

.method-text p{
margin:3px 0 0;
font-size:13px;
color:#666;
}


/* BACK */

.method-back{
margin-top:35px;
}

</style>

@endsection