<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('/img/bg-admin.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .login-box h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .login-box h2 {
            margin-bottom: 30px;
            font-size: 18px;
            color: #555;
        }
        input[type="email"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 30px;
            background: #004aad;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>CV. Mandiri Dwi Putra</h1>
        <h2>Sign in to Admin</h2>

        {{-- Pesan Error dari Session --}}
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        {{-- Error Validasi --}}
        @if($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Sign in</button>
        </form>

        <p style="margin-top: 15px;">
            Don't have an account? <a href="{{ route('admin.register.form') }}">Sign Up</a>
        </p>
    </div>
</body>
</html>
