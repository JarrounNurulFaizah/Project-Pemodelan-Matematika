@extends('layouts.admin')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        .dashboard-wrapper {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            font-family: 'Poppins', sans-serif;
        }

        .welcome-box {
            background-color: white;
            padding: 50px 60px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .welcome-box h1 {
            font-size: 36px;
            color: #002855;
            margin-bottom: 10px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-box p {
            font-size: 18px;
            color: #555;
            text-shadow: 0.5px 0.5px 2px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="welcome-box">
            <h1>Welcome, Admin!</h1>
        </div>
    </div>
@endsection
