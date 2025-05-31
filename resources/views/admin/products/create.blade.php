@extends('layouts.admin')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    .form-container h2 {
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    button {
        background-color: #004aad;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
    }

    button:hover {
        background-color: #003b8c;
    }
</style>

<div class="form-container">
    <h2>Add Products</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" required>
        </div>

        <div class="form-group">
            <label for="picture">Picture</label>
            <input type="file" name="picture" id="picture" accept="image/*">
        </div>

        <div class="form-group">
            <label for="description">Detail Product</label>
            <textarea name="description" id="description" rows="4"></textarea>
        </div>

        <button type="submit">Save Products</button>
    </form>
</div>
@endsection