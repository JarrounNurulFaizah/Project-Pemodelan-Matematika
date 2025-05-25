<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin')</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: #f8f8f8;
        }

        nav {
            background-color: #002f6c; /* biru dongker */
            padding: 10px 20px;
            color: white;
        }

        nav .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        nav form {
            display: inline;
            margin-left: 20px;
        }

        nav form button {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="navbar-container">
            <div><strong>CV. MANDIRI DWI PUTRA</strong></div>
            <div style="display: flex; align-items: center;">
                <a href="{{ url('/admin/home') }}">Home</a>
                <a href="{{ url('/admin/users') }}">User</a>
                <a href="{{ url('/admin/products') }}">Product</a>
                <a href="{{ url('/admin/transactions') }}">Transaction</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
