@extends('layouts.admin')

@section('title', 'Daftar Customer')

@section('content')
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">USER</h1>

    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        th {
            background-color: #004080;
            color: white;
            padding: 12px;
            text-align: left;
            border-radius: 8px 8px 0 0;
        }

        td {
            background-color: #f9f9f9;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            border-radius: 4px;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name Institution</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Registration Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name_institution }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
