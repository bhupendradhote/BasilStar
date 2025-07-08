@extends('layouts.adminLayout')

@section('content')
        <div class="max-w-7xl mx-auto mt-10 px-4">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">All Daily Strategies</h2>
        
            @if(session('success'))
                <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
        
            @forelse($strategies as $strategy)
            <div class="flex justify-end space-x-3 mt-4">
            <a href="{{ route('admin.strategy.edit', $strategy->id) }}" class="px-4 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
        
            <form action="{{ route('admin.strategy.destroy', $strategy->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this strategy?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 mb-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-xl font-semibold text-gray-800">{{ $strategy->title }}</h3>
                <span class="text-sm text-gray-500">{{ $strategy->created_at->format('d M Y, H:i') }}</span>
            </div>

            @if($strategy->image_url)
                <img src="{{ asset($strategy->image_url) }}" alt="Strategy Image" class="w-full rounded-md object-cover max-h-80 mb-4">
            @endif

            <p class="text-gray-700 whitespace-pre-line">{{ $strategy->description }}</p>
        </div>
    @empty
        <p class="text-gray-600">No strategies found.</p>
    @endforelse
</div>
@endsection
