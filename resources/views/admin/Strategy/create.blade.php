@extends('layouts.adminLayout')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Daily Strategy Update</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.strategy.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Strategy Title --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Strategy Title</label>
                <input type="text" name="title" required value="{{ old('title') }}" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Screenshot / Chart --}}
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Chart / Screenshot (optional)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full border border-gray-300 rounded-md p-2 bg-white focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Strategy Explanation --}}
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Strategy Explanation</label>
            <textarea name="description" rows="5" required class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        {{-- Submit --}}
        <div class="pt-6">
            <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Save Strategy
            </button>
        </div>
    </form>
</div>
@endsection
