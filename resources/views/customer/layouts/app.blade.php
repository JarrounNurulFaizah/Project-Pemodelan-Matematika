<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #002f6c;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">CV. MANDIRI DWI PUTRA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/customer/home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/customer/products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/customer/cart') }}">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/customer/history') }}">History</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link text-white fw-semibold" type="submit" style="text-decoration: none;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="py-4">
        @yield('content')
    </main>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>
