<!DOCTYPE html>
<html>
<head>
    <title>Welcome - PM2 Website</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f1f5f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            text-align: center;
        }
        .title {
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: bold;
            color: #1e293b;
        }
        .btn {
            display: inline-block;
            margin: 15px;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 10px;
            background-color: #1e40af;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Welcome to CV. Mandiri Dwi Putra</div>
        <a href="{{ route('admin.login') }}" class="btn">Login Admin</a>
        <a href="{{ route('customer.login') }}" class="btn">Login Customer</a>
    </div>
</body>
</html>
