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

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        /* HEADER */
        .topbar {
            background: #c40000;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
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
            height: 38px;
        }

        /* SIDEBAR */
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
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            transition: 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.2);
        }

        .sidebar hr {
            border-color: rgba(255,255,255,0.3);
        }

        /* CONTENT */
        .content {
            margin-top: 80px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .content.shift {
            margin-left: 240px;
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- HEADER -->
<div class="topbar">
    <div class="logo-area">
        <img src="{{ asset('images/logo-bawaslu.png') }}" alt="Logo Bawaslu">
        <strong>Sistem Internal Bawaslu Kabupaten Bogor</strong>
    </div>

    <div class="d-flex align-items-center gap-3">
        <span>{{ auth()->user()->name ?? 'Magang' }}</span>

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

    <h6 class="text-white mb-4">Menu Magang</h6>

    <!-- Dashboard -->
    <a href="{{ route('absensi.magang.dashboard') }}"
       class="{{ request()->routeIs('absensi.magang.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <hr>

    <!-- WFO -->
    <small class="text-white fw-bold d-block mb-2">Absen</small>

    <a href="{{ route('absensi.magang.masuk.form') }}"
       class="{{ request()->routeIs('absensi.magang.absen.*') ? 'active' : '' }}">
        <i class="bi bi-box-arrow-in-right"></i> Absen Masuk
    </a>

    <a href="{{ route('absensi.magang.pulang.form') }}"
       class="{{ request()->routeIs('absensi.magang.absen-pulang.*') ? 'active' : '' }}">
        <i class="bi bi-box-arrow-left"></i> Absen Pulang
    </a>

    <hr>
    <!-- Riwayat -->
    <a href="{{ route('absensi.magang.riwayat') }}"
       class="{{ request()->routeIs('absensi.magang.riwayat') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat Absensi
    </a>

</div>

<!-- CONTENT -->
<div class="content container-fluid">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Hover Script -->
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

    logo.addEventListener("mouseenter", openSidebar);

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

@yield('scripts')

</body>
</html>