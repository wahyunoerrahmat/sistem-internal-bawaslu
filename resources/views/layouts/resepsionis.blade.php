<!DOCTYPE html>
<html lang="id">
<head>

    <title>@yield('title','Sistem Resepsionis Bawaslu')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>

:root{
    --primary:#7A0E0E;
    --bg:#F4F6F9;
    --border:#E2E5E9;
}

body{
    background:var(--bg);
    font-family:'Segoe UI',sans-serif;
}


/* ================= TOPBAR ================= */
.topbar{
    height:64px;
    background:var(--primary);
    color:white;
    display:flex;
    align-items:center;
    padding:0 20px;
    position:fixed;
    top:0;
    left:0;
    right:0;
    z-index:1000;
    box-shadow:0 2px 6px rgba(0,0,0,.15);
}

.topbar img{
    height:42px;
}


/* ================= SIDEBAR ================= */
.sidebar{
    position:fixed;
    top:64px;
    left:0;
    width:230px;
    bottom:0;
    background:white;
    border-right:1px solid var(--border);
    padding-top:15px;
}

.sidebar a{
    display:block;
    padding:12px 20px;
    text-decoration:none;
    color:#444;
    font-weight:500;
}

.sidebar a:hover{
    background:#f1f3f5;
}

.sidebar i{
    margin-right:10px;
}


/* ================= CONTENT ================= */
.content-wrapper{
    margin-left:230px;
    margin-top:80px;
    padding:25px;
}


/* ================= FOOTER ================= */
.footer{
    margin-left:230px;
    background:white;
    border-top:1px solid var(--border);
    padding:12px;
    text-align:center;
    font-size:13px;
    color:#666;
    margin-top:40px;
}

</style>

</head>
<body>


{{-- ================= TOPBAR ================= --}}
<div class="topbar">

    <div class="d-flex align-items-center">

        <img src="{{ asset('images/logo-bawaslu.png') }}">

        <div class="ms-3">
            <div style="font-weight:600;font-size:15px;">
                BADAN PENGAWAS PEMILIHAN UMUM
            </div>

            <div style="font-size:12px;opacity:.9">
                Kabupaten Bogor — Sistem Resepsionis
            </div>
        </div>

    </div>


    <div class="ms-auto d-flex align-items-center gap-3">

        <div class="text-end">
            <div style="font-weight:600;font-size:14px;">
                {{ auth()->user()->name ?? 'User' }}
            </div>
            <div style="font-size:12px;opacity:.8">
                Resepsionis
            </div>
        </div>

        <div style="width:36px;height:36px;background:white;color:#7A0E0E;border-radius:50%;display:flex;align-items:center;justify-content:center;">
            <i class="fa fa-user"></i>
        </div>

    </div>

</div>



{{-- ================= SIDEBAR ================= --}}
<div class="sidebar">

    <a href="{{ route('resepsionis.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="{{ route('resepsionis.tamu.create') }}">
        <i class="bi bi-person-plus"></i>
        Input Tamu
    </a>

    <a href="{{ route('resepsionis.tamu') }}">
        <i class="bi bi-people"></i>
        Data Tamu
    </a>

    <a href="{{ route('resepsionis.statistik') }}">
        <i class="bi bi-bar-chart"></i>
        Statistik
    </a>

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn w-100 text-start px-3">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>

</div>



{{-- ================= CONTENT ================= --}}
<div class="content-wrapper">

    @yield('content')

</div>



{{-- ================= FOOTER ================= --}}
<div class="footer">
    Bawaslu Kabupaten Bogor © {{ date('Y') }}
</div>


</body>
</html>