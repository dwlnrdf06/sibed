<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiBed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif !important; box-sizing: border-box; }
        body { margin: 0; padding: 0; background: #f7f8f8; overflow-x: hidden; }
        .navbar-gradient {
            background: #1976D2;
            min-height: 90px; padding: 20px; position: fixed;
            top: 0; left: 0; right: 0; z-index: 99;
            display: flex; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .navbar-brand { font-size: 1.5rem; }
        .sidebar-fixed {
            position: fixed; top: 90px; left: 0; width: 250px;
            height: calc(100vh - 90px); background: linear-gradient( 180deg,#f7f8f8,#f7f8f8);;
            padding: 15px; z-index: 98; overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
            display: flex; flex-direction: column; align-items: center;
        }
        .menu-link {
            cursor: pointer; text-decoration: none;
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px; color: #333; border-radius: 5px;
        }
        .menu-link:hover { background-color: #1976D2; }
        .menu-link.active { background-color: #1976D2; color: white !important; }
        .menu-icon { font-size: 1rem; width: 20px; text-align: center; }
        .main-content { margin-left: 250px; margin-top: 90px; padding: 20px; min-height: calc(100vh - 90px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-gradient shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold text-white">
            Sistem Manajemen Tempat Tidur Rawat Inap (SiBed)
        </span>
        <span class="fw-semibold text-white" id="datetime"></span>
    </div>
</nav>

<div class="sidebar-fixed">
    <div class="d-flex justify-content-center align-items-center mb-4 mt-2">
        <img src="{{ asset('images/logo.png') }}" width="300" alt="Logo SiBed" class="img-fluid">
    </div>

    <ul class="nav flex-column w-100">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
               class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 menu-icon"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sensus') }}"
               class="menu-link {{ request()->routeIs('sensus') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-pulse menu-icon"></i> Sensus Harian
            </a>
        </li>
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-masuk.index') }}"
               class="menu-link {{ request()->routeIs('pasien-masuk.*') ? 'active' : '' }}">
                <i class="bi bi-person-add menu-icon"></i> Pasien Masuk
            </a>
        </li>
        @endif
        @if(in_array(auth()->user()->role, ['admin', 'perawat']))
        <li class="nav-item mb-2">
            <a href="{{ route('pasien-keluar.index') }}"
               class="menu-link {{ request()->routeIs('pasien-keluar.*') ? 'active' : '' }}">
                <i class="bi bi-person-dash menu-icon"></i> Pasien Keluar
            </a>
        </li>
        @endif
        @if(in_array(auth()->user()->role, ['admin', 'pmik']))
        <li class="nav-item mb-4">
            <a href="{{ route('rekap') }}"
               class="menu-link {{ request()->routeIs('rekap') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line menu-icon"></i> Rekapitulasi
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

<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
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