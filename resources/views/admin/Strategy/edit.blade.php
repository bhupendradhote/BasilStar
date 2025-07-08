@extends('layouts.adminLayout')

@section('content')
<div class="max-w-4xl mx-auto mt-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Daily Strategy</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.strategy.update', $strategy->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $strategy->title) }}" class="w-full border border-gray-300 rounded-md p-2">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Update Screenshot</label>
                <input type="file" name="image_file" class="w-full border border-gray-300 rounded-md p-2">
                @if($strategy->image_url)
                    <img src="{{ asset($strategy->image_url) }}" class="w-48 mt-2 rounded">
                @endif
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="5" class="w-full border border-gray-300 rounded-md p-2">{{ old('description', $strategy->description) }}</textarea>
        </div>

        <div class="pt-6">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Update Strategy
            </button>
        </div>
    </form>
</div>
@endsection
