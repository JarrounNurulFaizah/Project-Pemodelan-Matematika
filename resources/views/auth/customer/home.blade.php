<!-- resources/views/customer/home.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #002855;
            color: white;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-weight: bold;
            font-size: 18px;
        }

        .navbar .nav-links a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
        }

        .welcome {
            padding: 30px;
            text-align: center;
            background-color: white;
        }

        .products {
            padding: 20px 40px;
        }

        .products h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .product-card {
            width: 150px;
            height: 150px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">CV. MANDIRI DWI PUTRA</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Troli</a>
            <a href="#">History</a>
            <a href="#">Logout</a>
        </div>
    </div>

    @extends('layouts.customer')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; height: 70vh;">
        <div style="text-align: center; background-color: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Selamat datang di <strong>CV. Mandiri Dwi Putra</strong>!</h2>
        </div>
    </div>
@endsection


    <!-- Product Section -->
    <div class="products">
        <h2>Our Products</h2>
        <div class="product-grid">
            <div class="product-card">Product Name</div>
            <div class="product-card">Product Name</div>
            <div class="product-card">Product Name</div>
            <div class="product-card">Product Name</div>
            <div class="product-card">Product Name</div>
            <div class="product-card">Product Name</div>
        </div>
    </div>

</body>
</html>
