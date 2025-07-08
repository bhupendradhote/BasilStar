@extends('layouts.adminLayout')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Market Prediction</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.market-prediction.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" required value="{{ old('title') }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image_file" accept="image/*" class="w-full border border-gray-300 rounded-md p-2 bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Expected Range --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expected Range</label>
                <input type="text" name="range" value="{{ old('range') }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Market Sentiment --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Market Sentiment</label>
                <select name="market_sentiment" class="w-full border border-gray-300 rounded-md p-2 bg-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <option value="Bullish" {{ old('market_sentiment') == 'Bullish' ? 'selected' : '' }}>Bullish</option>
                    <option value="Bearish" {{ old('market_sentiment') == 'Bearish' ? 'selected' : '' }}>Bearish</option>
                    <option value="Neutral" {{ old('market_sentiment') == 'Neutral' ? 'selected' : '' }}>Neutral</option>
                </select>
            </div>

            {{-- Support Levels --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Support Levels</label>
                <input type="text" name="support_levels" value="{{ old('support_levels') }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Resistance Levels --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Resistance Levels</label>
                <input type="text" name="resistance_levels" value="{{ old('resistance_levels') }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Full Width Textareas (Below Grid) --}}
        <div class="mt-6 space-y-4">
            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            {{-- Global Cues --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Global Cues</label>
                <textarea name="global_cues" rows="2" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">{{ old('global_cues') }}</textarea>
            </div>

            {{-- Volatility Alert --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Volatility Alert</label>
                <textarea name="volatility_alert" rows="2" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-500">{{ old('volatility_alert') }}</textarea>
            </div>
        </div>

        {{-- Submit --}}
        <div class="pt-6">
            <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Save Prediction
            </button>
        </div>
    </form>
</div>
@endsection
