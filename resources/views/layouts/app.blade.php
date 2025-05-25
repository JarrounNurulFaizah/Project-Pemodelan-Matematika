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
            <a class="navbar-brand fw-bold" href="#">CV. MANDIRI DWI PUTRA</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/customer/home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/customer/products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/customer/cart') }}">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/customer/history') }}">History</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('customer.logout') }}" style="display: inline;">
                            @csrf
                            <button class="nav-link btn btn-link" type="submit" style="padding: 0; margin: 0; color: white;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
