@extends('layouts.customer')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
        
        <!-- Gambar Produk -->
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . $product->picture) }}" 
                 alt="{{ $product->name }}" 
                 class="rounded-xl shadow-md mb-4 object-cover"
                 style="width: 250px; height: auto;">
        </div>

        <!-- Info Produk -->
        <div class="flex flex-col space-y-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h2>
            <p class="text-xl text-blue-700 font-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($product->description)) !!}
            </div>

            <!-- Form Tambah ke Keranjang -->
            <form action="{{ route('customer.products.addToCart', $product) }}" method="POST" class="space-y-3">
                @csrf
                <label for="quantity" class="block font-medium text-gray-800">Jumlah:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1"
                       class="border border-gray-300 rounded p-2 w-24 mb-4">

                <div class="flex flex-col md:flex-row gap-3">
                    <button type="submit"
                            class="bg-black text-white font-semibold px-5 py-2 rounded hover:bg-gray-800 transition w-full md:w-auto">
                        Add to Cart
                    </button>
                </div>
            </form>

            <!-- Form Beli Langsung -->
            <form action="{{ route('customer.products.buyNow', $product) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="bg-black text-white font-semibold px-5 py-2 rounded hover:bg-gray-800 transition w-full md:w-auto">
                    Buy Now
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
