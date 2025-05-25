<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Customer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('/images/bg-customer.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
            width: 450px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #eef2f7;
            font-size: 14px;
        }

        button {
            background-color: #004aad;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #003b8c;
        }

        .login-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .login-link a {
            color: purple;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Sign Up</h2>

        @if ($errors->any())
            <div style="color:red; font-size: 14px; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('customer.register') }}">
            @csrf
            <input type="text" name="name_institution" placeholder="Name Institution" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('customer.login') }}">Sign in</a>
        </div>
    </div>
</body>
</html>
