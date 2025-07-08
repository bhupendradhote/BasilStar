@extends('layouts.adminLayout')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Market Basket</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.basket.update', $basket->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        {{-- Basket Type --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Basket Type</label>
            <select name="basket_type" required class="w-full border border-gray-300 rounded-md p-2 bg-white focus:ring-2 focus:ring-blue-500">
                <option value="">Select Basket Type</option>
                <option value="Intraday" {{ $basket->basket_type == 'Intraday' ? 'selected' : '' }}>Intraday Basket</option>
                <option value="Short Term" {{ $basket->basket_type == 'Short Term' ? 'selected' : '' }}>Short Term Basket</option>
                <option value="Long Term" {{ $basket->basket_type == 'Long Term' ? 'selected' : '' }}>Long Term Basket</option>
            </select>
        </div>

        {{-- Stock Basket --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Stock Basket</h3>
            <div id="basket-container" class="space-y-4">
                @foreach($basket->stocks as $i => $stock)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end basket-row">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Name</label>
                            <input type="text" name="basket[{{ $i }}][symbol]" value="{{ $stock->symbol }}" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buy Price (₹)</label>
                            <input type="number" step="0.01" name="basket[{{ $i }}][buy_price]" value="{{ $stock->buy_price }}" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Target (₹)</label>
                            <input type="number" step="0.01" name="basket[{{ $i }}][target_price]" value="{{ $stock->target_price }}" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stop Loss (₹)</label>
                            <input type="number" step="0.01" name="basket[{{ $i }}][stop_loss]" value="{{ $stock->stop_loss }}" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-red-500">
                        </div>
                        <div class="pt-6">
                            <button type="button" onclick="removeBasketRow(this)" class="text-red-500 hover:text-red-700 font-semibold">✕</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addBasketRow()" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">+ Add Stock</button>
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Update Basket
            </button>
        </div>
    </form>
</div>

{{-- JavaScript --}}
<script>
    let basketIndex = {{ $basket->stocks->count() }};

    function addBasketRow() {
        const container = document.getElementById('basket-container');

        const row = document.createElement('div');
        row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-5', 'gap-4', 'items-end', 'basket-row');

        row.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Name</label>
                <input type="text" name="basket[\${basketIndex}][symbol]" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buy Price (₹)</label>
                <input type="number" step="0.01" name="basket[\${basketIndex}][buy_price]" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Target (₹)</label>
                <input type="number" step="0.01" name="basket[\${basketIndex}][target_price]" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stop Loss (₹)</label>
                <input type="number" step="0.01" name="basket[\${basketIndex}][stop_loss]" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-red-500">
            </div>
            <div class="pt-6">
                <button type="button" onclick="removeBasketRow(this)" class="text-red-500 hover:text-red-700 font-semibold">✕</button>
            </div>
        `;

        container.appendChild(row);
        basketIndex++;
    }

    function removeBasketRow(button) {
        const row = button.closest('.basket-row');
        row.remove();
    }
</script>

@endsection
