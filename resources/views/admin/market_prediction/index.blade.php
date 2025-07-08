@extends('layouts.adminLayout')

@section('content')
<div class="max-w-6xl mx-auto px-4 mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Market Predictions</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @forelse($predictions as $prediction)
        <div class="bg-white p-6 rounded-xl shadow-md mb-6 relative">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $prediction->title }}</h3>
                    <span class="text-sm text-gray-500">{{ $prediction->created_at->format('d M Y, H:i') }}</span>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('admin.market-prediction.edit', $prediction->id) }}" class="px-3 py-1.5 text-sm font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.market-prediction.destroy', $prediction->id) }}" method="POST" onsubmit="return confirm('Delete this prediction?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            @if($prediction->image_url)
                <div class="mb-4">
                    <img src="{{ asset($prediction->image_url) }}" alt="Market Prediction Image" class="w-full rounded-md object-cover max-h-80">
                </div>
            @endif

            <p class="text-gray-700 mb-4">{{ $prediction->description }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-800">
                @if($prediction->market_sentiment)
                    <div><strong>Sentiment:</strong> {{ $prediction->market_sentiment }}</div>
                @endif

                @if($prediction->range)
                    <div><strong>Expected Range:</strong> {{ $prediction->range }}</div>
                @endif

                @if($prediction->global_cues)
                    <div><strong>Global Cues:</strong> {{ $prediction->global_cues }}</div>
                @endif

                @if($prediction->volatility_alert)
                    <div><strong>Volatility Alert:</strong> <span class="text-red-600">{{ $prediction->volatility_alert }}</span></div>
                @endif

                @if($prediction->support_levels)
                    <div><strong>Support Levels:</strong> {{ $prediction->support_levels }}</div>
                @endif

                @if($prediction->resistance_levels)
                    <div><strong>Resistance Levels:</strong> {{ $prediction->resistance_levels }}</div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-600">No predictions found.</p>
    @endforelse
</div>
@endsection
