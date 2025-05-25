@extends('layouts.admin')

@section('content')
<style>
    .form-container {
        max-width: 500px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-container label {
        font-weight: bold;
        display: block;
        margin-top: 15px;
    }
    .form-container input,
    .form-container textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-container button {
        margin-top: 20px;
        width: 100%;
        padding: 10px;
        background-color: #2196F3;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
    }
</style>

<div class="form-container">
    <h2>Edit Produk</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $product->name }}" required>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ $product->price }}" required>

        <label for="picture">Picture</label>
        <input type="file" name="picture" id="picture">

        <label for="description">Detail Product</label>
        <textarea name="description" id="description" rows="4">{{ $product->description }}</textarea>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
