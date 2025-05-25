@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">Produk Kami</h2>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-4"> <!-- Tiga kolom di layar besar -->
                <div class="card h-100 shadow-sm rounded-4">

                    <!-- Gambar Produk -->
                    <img 
                        src="{{ $product->picture ? asset('storage/' . $product->picture) : 'https://via.placeholder.com/300x130?text=No+Image' }}" 
                        alt="{{ $product->name }}" 
                        class="card-img-top rounded-top-4" 
                        style="height: 130px; object-fit: cover;"
                    >

                    <div class="card-body d-flex flex-column">
                        <!-- Nama Produk -->
                        <h6 class="card-title fw-semibold mb-2">{{ $product->name }}</h6>

                        <!-- Deskripsi Singkat -->
                        <p class="small text-muted mb-3">
                            {{ Str::limit($product->description, 55) }}
                        </p>

                        <!-- Harga Produk -->
                        <div class="mt-auto">
                            <span class="fw-bold text-primary d-block mb-2">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </span>

                            <!-- Tombol Add to Cart (optional) -->
                            <a href="{{ route('customer.add.to.cart', $product->id) }}" class="btn btn-sm btn-success w-100 rounded-3">
                                Tambahkan ke Troli
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada produk yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
