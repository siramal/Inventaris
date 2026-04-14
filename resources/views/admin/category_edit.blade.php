@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px] max-w-3xl">

        <h2 class="text-xl font-bold text-[#050A30] mb-1">Edit Category Forms</h2>
        <p class="text-gray-500 text-sm mb-8">
            Please <span class="text-pink-500">.fill-all</span> input form with right value.
        </p>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-[#050A30] text-sm font-medium mb-2">Name</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition text-gray-700">

                    @error('name')
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        </div>
                    @enderror
                </div>
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-10">
                <label class="block text-[#050A30] text-sm font-medium mb-2">Division PJ</label>
                <div class="flex relative">
                    <div
                        class="bg-gray-100 border {{ $errors->has('division') ? 'border-red-500' : 'border-gray-200' }} border-r-0 rounded-l-md px-4 flex items-center justify-center">
                        <i class="fa-solid fa-user-tie text-gray-400 text-sm"></i>
                    </div>

                    <select name="division"
                        class="w-full px-4 py-3 border {{ $errors->has('division') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} rounded-r-md focus:outline-none transition text-gray-700 bg-white cursor-pointer">
                        <option value="Sarpras" {{ old('division', $category->division) == 'Sarpras' ? 'selected' : '' }}>
                            Sarpras</option>
                        <option value="Tata Usaha"
                            {{ old('division', $category->division) == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                        <option value="tefa" {{ old('division', $category->division) == 'tefa' ? 'selected' : '' }}>tefa
                        </option>
                    </select>

                    @error('division')
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        </div>
                    @enderror
                </div>
                @error('division')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.categories') }}"
                    class="bg-[#9E9E9E] hover:bg-gray-500 text-white font-medium py-2 px-8 rounded transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-medium py-2 px-8 rounded transition">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
