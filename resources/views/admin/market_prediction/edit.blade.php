@extends('layouts.adminLayout')

@section('content')
<div class="max-w-3xl mx-auto px-4 mt-10">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Edit Market Prediction</h2>

    <form action="{{ route('admin.market-prediction.update', $prediction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $prediction->title) }}" class="w-full border border-gray-300 rounded-md p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Image (optional)</label>
            <input type="file" name="image_file" class="w-full border border-gray-300 rounded-md p-2">
            @if($prediction->image_url)
                <img src="{{ asset($prediction->image_url) }}" class="mt-2 w-40 h-auto rounded shadow">
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded-md p-2" rows="4">{{ old('description', $prediction->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expected Range</label>
                <input type="text" name="range" value="{{ old('range', $prediction->range) }}" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sentiment</label>
                <select name="market_sentiment" class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">Select</option>
                    <option value="Bullish" {{ old('market_sentiment', $prediction->market_sentiment) == 'Bullish' ? 'selected' : '' }}>Bullish</option>
                    <option value="Bearish" {{ old('market_sentiment', $prediction->market_sentiment) == 'Bearish' ? 'selected' : '' }}>Bearish</option>
                    <option value="Neutral" {{ old('market_sentiment', $prediction->market_sentiment) == 'Neutral' ? 'selected' : '' }}>Neutral</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Support Levels</label>
                <input type="text" name="support_levels" value="{{ old('support_levels', $prediction->support_levels) }}" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Resistance Levels</label>
                <input type="text" name="resistance_levels" value="{{ old('resistance_levels', $prediction->resistance_levels) }}" class="w-full border border-gray-300 rounded-md p-2">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Global Cues</label>
            <textarea name="global_cues" class="w-full border border-gray-300 rounded-md p-2">{{ old('global_cues', $prediction->global_cues) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Volatility Alert</label>
            <textarea name="volatility_alert" class="w-full border border-gray-300 rounded-md p-2">{{ old('volatility_alert', $prediction->volatility_alert) }}</textarea>
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
            Update Prediction
        </button>
    </form>
</div>
@endsection
