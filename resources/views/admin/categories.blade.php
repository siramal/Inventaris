@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Categories Table</h2>
                <p class="text-gray-500 text-sm mt-1">Add, delete, update <span class="text-pink-500">.categories</span></p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-[#20c997] hover:bg-[#1ba87e] text-white font-medium py-2 px-4 rounded transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                Add
            </a>
        </div>
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 flex items-center gap-3 shadow-sm rounded">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-4 px-6 text-gray-600 font-medium">#</th>
                        <th class="py-4 px-6 text-gray-600 font-medium">Name</th>
                        <th class="py-4 px-6 text-gray-600 font-medium">Division PJ</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Total Items</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 text-gray-700 font-medium">{{ $item->name }}</td>
                            <td class="py-4 px-6 text-gray-700">{{ $item->division }}</td>
                            <td class="py-4 px-6 text-gray-700 text-center">
                                {{ $item->items_count }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $item->id) }}"
                                        class="bg-[#6f42c1] hover:bg-[#59339e] text-white py-1 px-4 rounded text-sm transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded text-sm transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 block"></i>
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
