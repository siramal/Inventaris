@extends('layouts.app')

@section('title', 'Add Account')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px] max-w-3xl">

        <h2 class="text-xl font-bold text-[#050A30] mb-1">Add Account Forms</h2>
        <p class="text-gray-500 text-sm mb-8">
            Please <span class="text-pink-500">.fill-all</span> input form with right value.
        </p>

        <form action="{{ route('admin.users.admin.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-[#050A30] text-sm font-medium mb-2">Name</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Fema Flamelina Putri"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition text-gray-700">

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
                <label class="block text-[#050A30] text-sm font-medium mb-2">Email</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="femaflam22@gmail.com"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition text-gray-700">

                    @error('email')
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        </div>
                    @enderror
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-10">
                <label class="block text-[#050A30] text-sm font-medium mb-2">Role</label>
                <div class="relative">
                    <select name="role"
                        class="w-full px-4 py-3 rounded-md border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-200 focus:border-blue-400 focus:ring-1 focus:ring-blue-400' }} focus:outline-none transition text-gray-700 bg-white cursor-pointer">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                        <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>operator</option>
                    </select>

                    @error('role')
                        <div class="absolute inset-y-0 right-0 pr-8 flex items-center pointer-events-none">
                            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        </div>
                    @enderror
                </div>
                @error('role')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.users.admin') }}"
                    class="bg-[#9E9E9E] hover:bg-gray-500 text-white font-medium py-2 px-8 rounded transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-medium py-2 px-8 rounded transition">
                    Submit
                </button>
            </div>
        </form>

    </div>
@endsection
