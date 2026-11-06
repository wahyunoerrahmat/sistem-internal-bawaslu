<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>@yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ================= GLOBAL ================= */

body{
background:#f4f6f9;
overflow-x:hidden;
font-family:system-ui,-apple-system,Segoe UI,Roboto;
}

/* ================= HEADER ================= */

.topbar{
background:#c40000;
height:60px;
display:flex;
align-items:center;
padding:0 20px;
justify-content:space-between;
color:white;
width:100%;
position:fixed;
top:0;
z-index:1000;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.logo-area{
display:flex;
align-items:center;
gap:10px;
cursor:pointer;
}

.logo-area img{
height:40px;
}

.logo-area strong{
font-size:16px;
}

/* ================= SIDEBAR ================= */

.sidebar{
width:240px;
height:100vh;
position:fixed;
top:60px;
left:-240px;
background:#c40000;
padding:20px;
transition:left .3s ease;
z-index:999;
}

.sidebar.show{
left:0;
}

.sidebar h6{
font-weight:600;
}

.sidebar a{
color:white;
text-decoration:none;
display:flex;
align-items:center;
gap:8px;
padding:10px 12px;
border-radius:6px;
margin-bottom:8px;
transition:0.2s;
font-size:14px;
}

.sidebar a:hover,
.sidebar a.active{
background:rgba(255,255,255,0.2);
}

/* ================= CONTENT ================= */

.content{
margin-top:80px;
padding:30px;
transition:margin-left .3s ease;
min-height:100vh;
}

.content.shift{
margin-left:240px;
}

/* ================= CARD ================= */

.card{
border-radius:10px;
}

.card-header{
font-weight:600;
}

/* ================= STAT CARD ================= */

.stat-card{
border-left:5px solid #c40000;
transition:.3s;
}

.stat-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.stat-number{
font-size:26px;
font-weight:bold;
}

/* ================= TABLE ================= */

.table thead{
font-size:14px;
}

.table tbody{
font-size:14px;
}

/* ================= PRINT STYLE ================= */

@media print{

.topbar,
.sidebar,
.btn,
form,
.card-header{
display:none !important;
}

body{
background:white;
}

.content{
margin:0;
padding:0;
}

table{
font-size:12px;
}

img{
max-width:60px;
}

}

</style>

@yield('styles')

</head>

<body>

<!-- HEADER -->
<div class="topbar">

<div class="logo-area">

<img src="{{ asset('images/logo-bawaslu.png') }}" alt="Logo">

<strong>Sistem Internal Bawaslu Kabupaten Bogor</strong>

</div>

<div class="d-flex align-items-center gap-3">

@auth
<span>{{ auth()->user()->name }}</span>
@endauth

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-light btn-sm text-danger fw-bold">
Logout
</button>
</form>

</div>

</div>


<!-- SIDEBAR -->
<div class="sidebar">

<h6 class="text-white mb-4">Menu Admin Absensi</h6>

<a href="{{ route('absensi.admin.dashboard') }}"
class="{{ request()->routeIs('absensi.admin.dashboard') ? 'active' : '' }}">
<i class="bi bi-speedometer2"></i> Dashboard
</a>

<a href="{{ route('absensi.admin.users.index') }}"
class="{{ request()->routeIs('absensi.admin.users.*') ? 'active' : '' }}">
<i class="bi bi-people"></i> Manajemen Akun
</a>

<a href="{{ route('absensi.admin.laporan') }}"
class="{{ request()->routeIs('absensi.admin.laporan') ? 'active' : '' }}">
<i class="bi bi-calendar-check"></i> Laporan Absensi
</a>

</div>


<!-- CONTENT -->
<div class="content container-fluid">

@yield('content')

</div>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')


<!-- SIDEBAR HOVER SCRIPT -->
<script>

document.addEventListener("DOMContentLoaded",function(){

const logo=document.querySelector(".logo-area");
const sidebar=document.querySelector(".sidebar");
const content=document.querySelector(".content");

let timeout;

function openSidebar(){

sidebar.classList.add("show");
content.classList.add("shift");

}

function closeSidebar(){

sidebar.classList.remove("show");
content.classList.remove("shift");

}

logo.addEventListener("mouseenter",openSidebar);

sidebar.addEventListener("mouseenter",function(){

clearTimeout(timeout);
openSidebar();

});

logo.addEventListener("mouseleave",function(){

timeout=setTimeout(closeSidebar,200);

});

sidebar.addEventListener("mouseleave",function(){

timeout=setTimeout(closeSidebar,200);

});

});

</script>

</body>
</html>