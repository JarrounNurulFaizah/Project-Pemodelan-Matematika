@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">Our&nbsp;Products</h2>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-4"> {{-- 3 kolom di ≥992px --}}
                <a href="{{ route('customer.products.show', $product->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm rounded-4">

                        {{-- Gambar maksimal 130px --}}
                        <img
                            src="{{ $product->picture
                                    ? asset('storage/' . $product->picture)
                                    : 'https://via.placeholder.com/300x130?text=No+Image' }}"
                            alt="{{ $product->name }}"
                            class="card-img-top rounded-top-4"
                            style="height:130px; object-fit:cover;"
                        >

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-semibold mb-1">{{ $product->name }}</h6>
                            <p class="small text-secondary mb-2">
                                {{ \Illuminate\Support\Str::limit($product->description, 55) }}
                            </p>

                            <span class="mt-auto fw-bold text-primary">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">Belum ada produk.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
