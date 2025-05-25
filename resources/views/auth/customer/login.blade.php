<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Customer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .card h2 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .card p {
            margin-bottom: 30px;
            color: #666;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #e9f0fc;
            font-size: 14px;
        }

        button {
            background-color: #004aad;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background-color: #003b8c;
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: purple;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>CV. Mandiri Dwi Putra</h2>
        <p>Sign in to Customer</p>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('customer.login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Sign in</button>
        </form>

        <div class="register-link">
            Don't have an account? <a href="{{ route('customer.register.form') }}">Sign up</a>
        </div>
    </div>
</body>
</html>
