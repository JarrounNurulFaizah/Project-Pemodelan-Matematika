<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: url('/images/bg-admin.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            background-color: #1a3c8b;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            float: right;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up Admin</h2>
        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('admin.login') }}">Sign in</a>
        </div>
    </div>
</body>
</html>
