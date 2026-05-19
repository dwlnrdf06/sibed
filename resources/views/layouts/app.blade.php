<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiBed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
            box-sizing: border-box;
        }

        body {
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-gradient {
            background: linear-gradient(to right, #741a75, #f4c0ef);
            min-height: 90px;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-size: 1.5rem;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-fixed {
            position: fixed;
            top: 90px;
            left: 0;
            width: 250px;
            height: calc(100vh - 90px);
            background: #f8f9fa;
            padding: 15px;
            z-index: 98;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-link {
            cursor: pointer;
            text-decoration: none;
            display: block;
            padding: 8px 12px;
            color: #333;
            border-radius: 5px;
        }
        .menu-link:hover {
            background-color: #f4c0ef;
        }
        .menu-link.active {
            background-color: #741a75;
            color: white !important;
        }

        /* ===== KONTEN ===== */
        .main-content {
            margin-left: 250px;
            margin-top: 90px;
            padding: 20px;
            min-height: calc(100vh - 90px);
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-gradient shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold text-white">
            Sistem Manajemen Tempat Tidur Rawat Inap (SiBed)
        </span>
        <span class="fw-semibold text-white" id="datetime"></span>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar-fixed">
    <div class="d-flex justify-content-center align-items-center mb-4 mt-2">
        <img src="{{ asset('images/logo.png') }}" width="300" alt="Logo SiBed" class="img-fluid">
    </div>

    <ul class="nav flex-column w-100">

        {{-- Dashboard → semua role --}}
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
               class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        {{-- Sensus Harian → semua role --}}
        <li class="nav-item mb-2">
            <a href="{{ route('sensus') }}"
               class="menu-link {{ request()->routeIs('sensus') ? 'active' : '' }}">
                Sensus Harian
            </a>
        </li>

        {{-- Pasien Masuk → admin & perawat --}}
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-masuk.index') }}"
               class="menu-link {{ request()->routeIs('pasien-masuk.*') ? 'active' : '' }}">
                Pasien Masuk
            </a>
        </li>
        @endif

        {{-- Pasien Keluar → admin & perawat --}}
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-keluar.index') }}"
               class="menu-link {{ request()->routeIs('pasien-keluar.*') ? 'active' : '' }}">
                Pasien Keluar
            </a>
        </li>
        @endif

        {{-- Rekapitulasi → admin & pmik --}}
        @if(in_array(auth()->user()->role, ['admin', 'pmik']))
        <li class="nav-item mb-4">
            <a href="{{ route('rekap') }}"
               class="menu-link {{ request()->routeIs('rekap') ? 'active' : '' }}">
                Rekapitulasi
            </a>
        </li>
        @endif

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </li>
    </ul>
</div>

<!-- KONTEN UTAMA -->
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateDateTime() {
        const now = new Date();
        const el = document.getElementById('datetime');
        if (el) {
            el.innerHTML = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: '2-digit',
                month: 'long', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
</body>
</html>