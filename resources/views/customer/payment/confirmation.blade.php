{{-- resources/views/customer/payment/confirmation.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-900 uppercase">Payment Confirmation</h2>

        <form action="{{ route('customer.payment.store', $transaction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Name Institution --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Name Institution</label>
                <input type="text" name="institution_name" value="{{ old('institution_name') }}" 
                       class="mt-1 border border-gray-300 rounded w-full p-2 focus:ring focus:ring-blue-300" required>
                @error('institution_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Payment Method --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Payment Method</label>
                <select name="payment_method" 
                        class="mt-1 border border-gray-300 rounded w-full p-2 focus:ring focus:ring-blue-300" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="BNI" {{ old('payment_method') == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="BCA" {{ old('payment_method') == 'BCA' ? 'selected' : '' }}>BCA</option>
                </select>
                @error('payment_method')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Payment Proof --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Attach Proof of Payment</label>
                <input type="file" name="payment_proof" accept="image/*" 
                       class="mt-1 border border-gray-300 rounded w-full p-2" required>
                <small class="text-gray-500">Max 5 MB</small>
                @error('payment_proof')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" 
                    class="bg-blue-900 text-white font-semibold py-2 px-4 rounded w-full hover:bg-blue-800">
                SEND
            </button>
        </form>
    </div>
</div>
@endsection
