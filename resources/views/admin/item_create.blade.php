@extends('layouts.app')

@section('title', 'Add Item')

@section('content')
<div class="bg-white rounded-md shadow-md p-8 min-h-[400px] max-w-3xl">
    
    <h2 class="text-xl font-bold text-[#050A30] mb-1">Add Item Forms</h2>
    <p class="text-gray-500 text-sm mb-8">
        Please <span class="text-pink-500">.fill-all</span> input form with right value.
    </p>

    <form action="{{ route('admin.items.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-[#050A30] text-sm font-medium mb-2">Name</label>
            <div class="relative">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Alat Dapur" 
                    class="w-full px-4 py-3 rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition placeholder-gray-300 text-gray-700">
                
                @error('name')
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    </div>
                @enderror
            </div>
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-[#050A30] text-sm font-medium mb-2">Category</label>
            <div class="relative">
                <select name="category_id" 
                    class="w-full px-4 py-3 rounded-md border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition text-gray-700 bg-white appearance-none cursor-pointer">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <div class="absolute inset-y-0 right-0 pr-8 flex items-center pointer-events-none">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    </div>
                @enderror
            </div>
            @error('category_id')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-10">
            <label class="block text-[#050A30] text-sm font-medium mb-2">Total</label>
            <div class="flex relative">
                <input type="number" name="total" value="{{ old('total') }}" placeholder="10" min="1"
                    class="w-full px-4 py-3 border {{ $errors->has('total') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} border-r-0 rounded-l-md focus:outline-none transition placeholder-gray-300 text-gray-700">
                
                <div class="bg-gray-100 border {{ $errors->has('total') ? 'border-red-500' : 'border-gray-200' }} border-l-0 rounded-r-md px-4 py-3 flex items-center justify-center text-gray-400 text-sm">
                    item
                </div>

                @error('total')
                    <div class="absolute inset-y-0 right-16 pr-2 flex items-center pointer-events-none">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    </div>
                @enderror
            </div>
            @error('total')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.items') }}" class="bg-[#9E9E9E] hover:bg-gray-500 text-[#050A30] font-medium py-2 px-8 rounded transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-medium py-2 px-8 rounded transition">
                Submit
            </button>
        </div>
    </form>

</div>
@endsection