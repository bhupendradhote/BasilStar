@extends('layouts.adminLayout')

@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">All Market Baskets</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 text-right">
        <a href="{{ route('admin.basket.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Create New Basket
        </a>
    </div>

    @forelse ($baskets as $basket)
        <div class="bg-white shadow rounded-lg mb-6 p-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-gray-800">{{ $basket->basket_type }} Basket</h3>
                <div class="flex gap-2">
                    <a href="{{ route('admin.basket.edit', $basket->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.basket.destroy', $basket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this basket?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>

            <table class="w-full text-sm border border-gray-200 rounded overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 text-left">Symbol</th>
                        <th class="p-2 text-left">Buy Price (₹)</th>
                        <th class="p-2 text-left">Target (₹)</th>
                        <th class="p-2 text-left">Stop Loss (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($basket->stocks as $stock)
                        <tr class="border-t">
                            <td class="p-2">{{ $stock->symbol }}</td>
                            <td class="p-2">{{ $stock->buy_price }}</td>
                            <td class="p-2">{{ $stock->target_price }}</td>
                            <td class="p-2">{{ $stock->stop_loss }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p class="text-gray-600">No baskets available.</p>
    @endforelse
</div>
@endsection
