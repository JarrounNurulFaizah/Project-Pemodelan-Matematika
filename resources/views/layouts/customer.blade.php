{{-- resources/views/layouts/customer.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Customer – CV. Mandiri Dwi Putra')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    {{-- Optional: Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f8fb;
        }

        .navbar-custom {
            background-color: #002855;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 20px;
            color: #ffffff !important;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            margin-left: 15px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #00d1b2 !important;
        }

        .navbar-nav .nav-link.logout:hover {
            color: #ff4d4f !important;
        }

        main {
            padding: 40px;
        }
    </style>
</head>
<body>
    {{-- ────────── NAVBAR ────────── --}}
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('customer.home') }}">CV. MANDIRI DWI PUTRA</a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.home') }}"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.products.index') }}"><i class="bi bi-box-seam"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.cart') }}"><i class="bi bi-cart"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.history') }}"><i class="bi bi-clock-history"></i> History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="{{ route('customer.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ────────── KONTEN ────────── --}}
    <main>
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
