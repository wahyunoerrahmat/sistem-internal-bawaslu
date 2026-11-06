<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        /* ================= HEADER ================= */
        .topbar {
            background: #c40000;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
            color: white;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .logo-area img {
            height: 40px;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 60px;
            left: -240px;
            background: #c40000;
            padding: 20px;
            transition: left 0.3s ease;
            z-index: 999;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
        }

        /* ================= CONTENT ================= */
        .content {
            margin-top: 80px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .content.shift {
            margin-left: 240px;
        }

        .stat-card {
            border-left: 5px solid #c40000;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="topbar">
    <div class="logo-area">
        <img src="{{ asset('images/logo-bawaslu.png') }}" alt="Logo Bawaslu">
        <strong>Sistem Internal Bawaslu</strong>
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
    <h6 class="text-white mb-4">Menu Pimpinan</h6>

    <a href="{{ route('pimpinan.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('pimpinan.absensi.index') }}">
        <i class="bi bi-calendar-check"></i> Data Absensi
    </a>

    <a href="{{ route('pimpinan.barang.index') }}">
        <i class="bi bi-box-seam"></i> Data Barang
    </a>

    <a href="{{ route('pimpinan.admin.index') }}">
        <i class="bi bi-people"></i> Kelola Admin
    </a>
</div>

<!-- CONTENT -->
<div class="content container-fluid">
    @yield('content')
</div>

@yield('scripts')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Hover Script (FIX SHIFT CONTENT) -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const logo = document.querySelector(".logo-area");
    const sidebar = document.querySelector(".sidebar");
    const content = document.querySelector(".content");

    let timeout;

    function openSidebar() {
        sidebar.classList.add("show");
        content.classList.add("shift");
    }

    function closeSidebar() {
        sidebar.classList.remove("show");
        content.classList.remove("shift");
    }

    logo.addEventListener("mouseenter", function () {
        openSidebar();
    });

    sidebar.addEventListener("mouseenter", function () {
        clearTimeout(timeout);
        openSidebar();
    });

    logo.addEventListener("mouseleave", function () {
        timeout = setTimeout(closeSidebar, 200);
    });

    sidebar.addEventListener("mouseleave", function () {
        timeout = setTimeout(closeSidebar, 200);
    });

});
</script>

</body>
</html>