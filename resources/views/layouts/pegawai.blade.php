<!DOCTYPE html>

<html lang="id">
<head>

<meta charset="UTF-8">
<title>{{ $title ?? 'Dashboard Pegawai' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font -->

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ================= GLOBAL ================= */

body{
    font-family:'Inter',sans-serif;
    background:#f4f6f9;
}


/* ================= HEADER ================= */

.header{
    background:#d50000;
    height:60px;
    position:fixed;
    top:0;
    width:100%;
    z-index:1000;
}


/* ================= SIDEBAR ================= */

.sidebar{
    position:fixed;
    top:60px;
    left:-240px;
    width:240px;
    height:calc(100vh - 60px);
    background:#d50000;
    transition:0.3s ease;
    z-index:999;
    padding-top:15px;
}


/* AREA DETEKSI POINTER */

.sidebar-trigger{
    position:fixed;
    top:0;
    left:0;
    width:80px;
    height:100vh;
    z-index:998;
}


/* SIDEBAR MUNCUL */

.sidebar-trigger:hover ~ .sidebar,
.sidebar:hover{
    left:0;
}


/* ================= MENU ================= */

.sidebar-link{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 18px;
    margin:6px 10px;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:.25s;
}

.sidebar-link:hover{
    background:rgba(255,255,255,.15);
    transform:translateX(5px);
}

.sidebar-link.active{
    background:white;
    color:#d50000 !important;
    font-weight:600;
}


/* ================= CONTENT ================= */

.content{
    margin-top:70px;
    padding:30px;
    transition:0.3s;
}

.sidebar-trigger:hover ~ .content,
.sidebar:hover ~ .content{
    margin-left:240px;
}


/* ================= MOBILE ================= */

@media(max-width:768px){

.sidebar{
    left:-240px;
}

.content{
    margin-left:0!important;
}

}

</style>

</head>

<body>

<!-- ================= HEADER ================= -->

<nav class="header navbar navbar-dark px-3 d-flex justify-content-between">

<a href="{{ route('pegawai.dashboard') }}"
class="d-flex align-items-center gap-2 text-white text-decoration-none">

<img src="{{ asset('images/logo-bawaslu.png') }}" height="35">

<strong>Sistem Internal Bawaslu Kabupaten Bogor</strong>

</a>

<div class="d-flex align-items-center gap-3 text-white">

<i class="bi bi-person-circle fs-5"></i>

<span>{{ auth()->user()->name }}</span>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-light btn-sm text-danger fw-semibold">
Logout
</button>
</form>

</div>

</nav>

<!-- AREA HOVER -->

<div class="sidebar-trigger"></div>

<!-- ================= SIDEBAR ================= -->

<div class="sidebar">

<div class="px-3 text-white small fw-bold opacity-75 mb-2">
MENU PEGAWAI
</div>

<a href="{{ route('pegawai.dashboard') }}"
class="sidebar-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">

<i class="bi bi-speedometer2"></i>
Dashboard

</a>

<a href="{{ route('pegawai.barang.index') }}"
class="sidebar-link {{ request()->routeIs('pegawai.barang*') ? 'active' : '' }}">

<i class="bi bi-box-seam"></i>
Peminjaman Barang

</a>

<a href="{{ route('pegawai.laporan.index') }}"
class="sidebar-link {{ request()->routeIs('pegawai.laporan*') ? 'active' : '' }}">

<i class="bi bi-journal-text"></i>
Laporan Peminjaman

</a>

</div>

<!-- ================= CONTENT ================= -->

<div class="content container-fluid">

@yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
