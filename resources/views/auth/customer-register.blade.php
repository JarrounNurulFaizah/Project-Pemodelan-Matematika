<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #0d3b66;
            border: none;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #092e4e;
        }
        .login-link {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-5" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4">Sign Up</h3>

        <form method="POST" action="{{ route('customer.register') }}">
            @csrf

            <div class="mb-3">
                <label for="name_institution" class="form-label">Name Institution</label>
                <input type="text" id="name_institution" name="name_institution" class="form-control @error('name_institution') is-invalid @enderror" value="{{ old('name_institution') }}" required>
                @error('name_institution')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>

            <div class="login-link">
                <small>Already have an account? <a href="{{ route('customer.login') }}">Sign in</a></small>
            </div>

        </form>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
