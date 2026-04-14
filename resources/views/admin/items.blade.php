@extends('layouts.app')

@section('title', 'Items')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Items Table</h2>
                <p class="text-gray-500 text-sm mt-1">Add, delete, update <span class="text-pink-500">.items</span></p>
            </div>

            <div class="flex gap-3">
                <button class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-medium py-2 px-6 rounded transition">
                    Export Excel
                </button>

                <a href="{{ route('admin.items.create') }}"
                    class="bg-[#20c997] hover:bg-[#1ba87e] text-white font-medium py-2 px-6 rounded transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Add
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-4 px-6 text-gray-600 font-medium">#</th>
                        <th class="py-4 px-6 text-gray-600 font-medium">Category</th>
                        <th class="py-4 px-6 text-gray-600 font-medium">Name</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Total</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Repair</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Lending</th>
                        <th class="py-4 px-6 text-gray-600 font-medium text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Melakukan looping data dari database --}}
                    @forelse ($items as $index => $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-6 text-center text-gray-700">{{ $index + 1 }}</td>

                            <td class="py-4 px-6 text-gray-700">{{ $item->category->name }}</td>

                            <td class="py-4 px-6 text-gray-700">{{ $item->name }}</td>

                            <td class="py-4 px-6 text-gray-700 text-center">{{ $item->total }}</td>

                            <td class="py-4 px-6 text-gray-700 text-center">{{ $item->repair }}</td>

                            <td class="py-4 px-6 text-center">
                                @if ($item->lending_count > 0)
                                    <a href="{{ route('admin.items.lending', $item->id) }}"
                                        class="text-[#007bff] hover:underline font-medium">
                                        {{ $item->lending_count }}
                                    </a>
                                @else
                                    <span class="text-gray-700">0</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.items.edit', $item->id) }}"
                                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white py-1 px-5 rounded text-sm transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                Belum ada data item. Silakan tambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
