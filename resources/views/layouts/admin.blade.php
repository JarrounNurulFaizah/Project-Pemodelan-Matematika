<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin – CV. Mandiri Dwi Putra')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons (optional) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f8fb;
        }

        nav {
            background: #002855;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .05);
        }

        .brand {
            color: #fff;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #00d1b2;
        }

        .nav-links .logout:hover {
            color: #ff4d4f;
        }

        main {
            padding: 40px;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>
    {{-- ────────── NAVBAR ────────── --}}
    <nav>
        <div class="brand">CV. MANDIRI DWI PUTRA</div>

        <div class="nav-links">
            <a href="{{ url('/admin/home') }}">
                <i data-lucide="home"></i> Home
            </a>
            <a href="{{ url('/admin/users') }}">
                <i data-lucide="users"></i> Users
            </a>
            <a href="{{ url('/admin/products') }}">
                <i data-lucide="box"></i> Products
            </a>
            <a href="{{ url('/admin/transactions') }}">
                <i data-lucide="credit-card"></i> Transactions
            </a>

            <a href="{{ route('admin.logout') }}" class="logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-lucide="log-out"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    {{-- ────────── KONTEN ────────── --}}
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS + Lucide Init -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons(); // Aktifkan ikon Lucide
    </script>
</body>
</html>
