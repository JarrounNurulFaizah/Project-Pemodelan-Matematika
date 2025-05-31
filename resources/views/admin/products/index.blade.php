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

    .btn-add {
        background-color: #004aad;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-add:hover {
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
        object-fit: cover;
    }
</style>

<div class="container">
    <div class="header-section">
        <h2>Product List</h2>
        <a href="{{ route('admin.products.create') }}" class="btn-add">+ Add Product</a>
    </div>

    @if($products->isEmpty())
        <div class="no-product">No products available</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Description</th>
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
                            <img src="{{ asset('storage/' . $product->picture) }}" alt="Product Image" class="product-image">
                        @else
                            <span style="color: #888;">No image</span>
                        @endif
                    </td>
                    <td>{{ $product->description }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
