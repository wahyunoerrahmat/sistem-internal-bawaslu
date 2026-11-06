<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>@yield('title') - Sistem Internal Bawaslu Kabupaten Bogor</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>

/* ======================
GLOBAL
====================== */

body{
margin:0;
font-family:Arial, sans-serif;
background:#f4f6f9;
}

.layout{
display:flex;
}


/* ======================
SIDEBAR
====================== */

.sidebar{
position:fixed;
top:0;
left:0;
width:0;
height:100vh;
background:linear-gradient(180deg,#c40000,#990000);
color:white;
overflow:hidden;
transition:0.3s;
z-index:1000;
box-shadow:4px 0 10px rgba(0,0,0,0.15);
}

.sidebar-content{
width:230px;
padding-top:80px;
}

.menu{
padding:10px;
}

.menu-title{
font-size:11px;
opacity:0.7;
margin:15px 10px 6px;
text-transform:uppercase;
letter-spacing:1px;
}

.menu a{
display:flex;
align-items:center;
gap:10px;
padding:12px 14px;
margin-bottom:6px;
border-radius:6px;
color:white;
text-decoration:none;
font-size:14px;
transition:0.2s;
}

.menu a:hover{
background:rgba(255,255,255,0.15);
}

.menu a.active{
background:white;
color:#c40000;
font-weight:bold;
}


/* ======================
MAIN AREA
====================== */

.main{
width:100%;
transition:0.3s;
}


/* ======================
HEADER TOP
====================== */

.header{
background:#c40000;
color:white;
padding:12px 25px;
display:flex;
justify-content:space-between;
align-items:center;
}

.header-left{
display:flex;
align-items:center;
gap:12px;
text-decoration:none;
color:white;
}

.header-left img{
height:40px;
}

.header-title{
font-size:18px;
font-weight:bold;
}

.logout-btn{
background:white;
color:#c40000;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
font-weight:bold;
}


/* ======================
CONTENT
====================== */

.container{
padding:30px;
}

.title{
font-size:26px;
color:#c40000;
margin-bottom:20px;
font-weight:bold;
}


/* ======================
PAGE HEADER (PROFESSIONAL)
====================== */

.page-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
flex-wrap:wrap;
gap:15px;
}

.header-icon{
width:48px;
height:48px;
background:#f1f3f5;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
font-size:22px;
color:#333;
}

.header-subtitle{
margin:0;
font-size:13px;
color:#888;
}

.header-action{
display:flex;
gap:10px;
}

.btn-action{
display:flex;
align-items:center;
gap:6px;
padding:8px 14px;
font-size:14px;
border-radius:8px;
}


/* ======================
CARD
====================== */

.card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 10px rgba(0,0,0,0.08);
margin-bottom:20px;
}


/* ======================
TABLE
====================== */

.table{
width:100%;
border-collapse:collapse;
}

.table th{
background:#f8d7da;
padding:10px;
text-align:left;
}

.table td{
padding:10px;
border-top:1px solid #eee;
}


/* ======================
INPUT
====================== */

input, select{
padding:8px;
border:1px solid #ccc;
border-radius:5px;
width:100%;
}


/* ======================
SIDEBAR HOVER SYSTEM
====================== */

.hover-trigger{
position:fixed;
top:0;
left:0;
width:20px;
height:100vh;
z-index:1100;
}

.hover-trigger:hover + .sidebar,
.sidebar:hover{
width:230px;
}

.hover-trigger:hover ~ .main,
.sidebar:hover ~ .main{
margin-left:230px;
}

</style>
</head>

<body>

<div class="layout">

<!-- Hover Trigger -->
<div class="hover-trigger"></div>


<!-- SIDEBAR -->
<div class="sidebar">

<div class="sidebar-content">

<div class="menu">

<div class="menu-title">Manajemen</div>

<a href="{{ route('barang.admin.user.index') }}"
class="{{ request()->routeIs('barang.admin.user.*') ? 'active' : '' }}">
<i class="bi bi-people"></i>
Manajemen User
</a>

<a href="{{ route('barang.admin.barang.index') }}"
class="{{ request()->routeIs('barang.admin.barang.*') ? 'active' : '' }}">
<i class="bi bi-box-seam"></i>
Data Barang
</a>


<div class="menu-title">Transaksi</div>

<a href="{{ route('barang.admin.peminjaman.index') }}"
class="{{ request()->routeIs('barang.admin.peminjaman.*') ? 'active' : '' }}">
<i class="bi bi-arrow-left-right"></i>
Peminjaman
</a>


<div class="menu-title">Laporan</div>

<a href="{{ route('barang.admin.laporan.index') }}"
class="{{ request()->routeIs('barang.admin.laporan.*') ? 'active' : '' }}">
<i class="bi bi-file-earmark-text"></i>
Laporan
</a>

</div>

</div>

</div>



<!-- MAIN -->
<div class="main">


<!-- HEADER -->
<div class="header">

<a href="{{ route('barang.admin.dashboard') }}" class="header-left">

<img src="{{ asset('images/logo-bawaslu.png') }}">

<div class="header-title">
Sistem Internal Bawaslu Kabupaten Bogor
</div>

</a>

<div style="display:flex;align-items:center;gap:10px;">

@auth
<span>{{ auth()->user()->name }}</span>
@endauth

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="logout-btn">Logout</button>
</form>

</div>

</div>


<!-- CONTENT -->
<div class="container">
@yield('content')
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>