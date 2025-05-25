
@extends('layouts.admin')

@section('title', 'Admin Home')

@section('content')
    <div class="welcome-box">
        <h1>WELCOME</h1>
    </div>

    <style>
        .welcome-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 80px auto;
            text-align: center;
        }
    </style>
@endsection
