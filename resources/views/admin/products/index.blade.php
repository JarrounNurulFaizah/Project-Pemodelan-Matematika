@extends('layouts.admin')

@section('content')
<style>
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .header-section h2 {
        font-size: 24px;
        font-weight: 600;
    }

    .btn-tambah {
        background-color: #004aad;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-tambah:hover {
        background-color: #003b8c;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
        margin-top: 10px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f0f0f0;
        font-weight: 600;
    }

    .no-product {
        padding: 20px;
        text-align: center;
        color: #666;
    }

    .action-buttons a,
    .action-buttons button {
        background-color: #004aad;
        color: white;
        padding: 6px 12px;
        margin-right: 5px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
    }

    .action-buttons button:hover,
    .action-buttons a:hover {
        background-color: #003b8c;
    }

    .product-image {
        width: 80px;
        height: auto;
        border-radius: 6px;
    }
</style>

<div class="container">
    <div class="header-section">
        <h2>Product List</h2>
        <a href="{{ route('admin.products.create') }}" class="btn-tambah">+ Add Products</a>
    </div>

    @if($products->isEmpty())
        <div class="no-product">No products yet</div>
    @else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Picture</th>
                <th>Detail Product</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if ($product->picture)
                            <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            No image
                        @endif
                    </td>
                    <td>{{ $product->description }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Remove this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
