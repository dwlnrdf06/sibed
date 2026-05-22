<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiBed</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        * {
            font-family: 'Poppins', sans-serif !important;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f7f8f8;
            overflow-x: hidden;
        }

        /* ================= NAVBAR ================= */

        .navbar-gradient {
            background: #1976D2;
            height: 95px;
            padding: 12px 20px;

            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            z-index: 99;

            display: flex;
            align-items: center;

            box-shadow: 0 2px 10px rgba(0,0,0,0.15);

            overflow: hidden;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        /* ================= SIDEBAR ================= */

        .sidebar-fixed {
            position: fixed;

            top: 95px;
            left: 0;

            width: 250px;
            height: calc(100vh - 95px);

            background: #1565C0;

            padding: 15px;

            z-index: 98;

            overflow-y: auto;

            box-shadow: 2px 0 10px rgba(0,0,0,0.08);

            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ================= MENU ================= */

        .menu-link {
            cursor: pointer;
            text-decoration: none;

            display: flex;
            align-items: center;
            gap: 8px;

            padding: 10px 14px;

            color: #fff9f9;

            border-radius: 8px;

            transition: 0.2s;
        }

        .menu-link:hover {
            background-color: #1976D2;
            color: white;
        }

        .menu-link.active {
            background-color: #e6e9ef;
            color: black !important;
        }

        .menu-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        /* ================= CONTENT ================= */

        .main-content {
            margin-left: 250px;
            margin-top: 95px;

            padding: 20px;

            min-height: calc(100vh - 95px);
        }

        /* ================= PROFIL ================= */

        .profil-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.2);
            padding: 6px 15px;
            border-radius: 25px;
        }

        .profil-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .profil-nama {
            color: white;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
        }

        .profil-role {
            color: rgba(255,255,255,0.85);
            font-size: 11px;
            text-transform: capitalize;
        }

    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg navbar-gradient shadow-sm">

    <div class="container-fluid">

        {{-- BRAND --}}
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-1"
           href="{{ route('dashboard') }}">

            <span>Sistem Manajemen Tempat Tidur Rawat Inap</span>

            <img src="{{ asset('images/SiBedName.png') }}"
                 alt="Logo"
                 style="
                    height: 120px;
                    width: auto;
                    object-fit: contain;
                    margin-top: -5px;
                    margin-bottom: -10px;
                    margin-left: -12px;
                 ">

        </a>

        {{-- KANAN: Jam + Profil --}}
        <div class="d-flex align-items-center gap-3">

            {{-- JAM --}}
            <span class="fw-semibold text-white" id="datetime"></span>

            {{-- PROFIL --}}
            <div class="profil-box">

                <div class="profil-avatar">👤</div>

                <div>
                    <div class="profil-nama">{{ auth()->user()->name }}</div>
                    <div class="profil-role">{{ auth()->user()->role }}</div>
                </div>

            </div>

        </div>

    </div>

</nav>

<!-- ================= SIDEBAR ================= -->

<div class="sidebar-fixed">

    <!-- LOGO -->
    <div class="d-flex justify-content-center align-items-center mb-4 mt-2">
        <img src="{{ asset('images/logo2.png') }}"
             width="300"
             alt="Logo SiBed"
             class="img-fluid">
    </div>

    <!-- MENU -->
    <ul class="nav flex-column w-100">

        <!-- DASHBOARD -->
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
               class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 menu-icon"></i>
                Dashboard
            </a>
        </li>

        <!-- SENSUS -->
        <li class="nav-item mb-2">
            <a href="{{ route('sensus') }}"
               class="menu-link {{ request()->routeIs('sensus') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-pulse menu-icon"></i>
                Sensus Harian
            </a>
        </li>

        <!-- PASIEN MASUK -->
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-masuk.index') }}"
               class="menu-link {{ request()->routeIs('pasien-masuk.*') ? 'active' : '' }}">
                <i class="bi bi-person-add menu-icon"></i>
                Pasien Masuk
            </a>
        </li>
        @endif

        <!-- PASIEN KELUAR -->
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-keluar.index') }}"
               class="menu-link {{ request()->routeIs('pasien-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-person-dash menu-icon"></i>
                Pasien Keluar
            </a>
        </li>
        @endif

        <!-- REKAP -->
        @if(in_array(auth()->user()->role, ['admin', 'pmik']))
        <li class="nav-item mb-4">
            <a href="{{ route('rekap') }}"
               class="menu-link {{ request()->routeIs('rekap') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line menu-icon"></i>
                Rekapitulasi
            </a>
        </li>
        @endif

        <!-- LOGOUT -->
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    Logout
                </button>
            </form>
        </li>

    </ul>

</div>

<!-- ================= MAIN CONTENT ================= -->

<div class="main-content">
    @yield('content')
</div>

<!-- ================= JS ================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

<script>
    function updateDateTime() {
        const now = new Date();
        const el  = document.getElementById('datetime');
        if (el) {
            el.innerHTML = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day:     '2-digit',
                month:   'long',
                year:    'numeric',
                hour:    '2-digit',
                minute:  '2-digit'
            });
        }
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

</body>
</html>