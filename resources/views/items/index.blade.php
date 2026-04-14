@extends('layouts.app')

@section('title', 'Items Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        {{-- Header: Tombol Add & Export hanya untuk Admin --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Items Table</h2>
                <p class="text-gray-500 text-sm mt-1">
                    @if(Auth::user()->role === 'admin')
                        Add, delete, update <span class="text-pink-500">.items</span>
                    @else
                        Data of <span class="text-pink-500">.items</span>
                    @endif
                </p>
            </div>

            @if(Auth::user()->role === 'admin')
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
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-600">
                        <th class="py-4 px-6 font-medium">#</th>
                        <th class="py-4 px-6 font-medium">Category</th>
                        <th class="py-4 px-6 font-medium">Name</th>
                        <th class="py-4 px-6 font-medium text-center">Total</th>
                        <th class="py-4 px-6 font-medium text-center">Available</th>
                        <th class="py-4 px-6 font-medium text-center">Lending Total</th>
                        {{-- Kolom Action hanya muncul untuk Admin --}}
                        @if(Auth::user()->role === 'admin')
                            <th class="py-4 px-6 font-medium text-center">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $item)
                        @php
                            $lendingTotal = $item->total_dipinjam ?? $item->lendings_count ?? 0;
                            $available = $item->total - ($lendingTotal + $item->repair);
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-6 text-center text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 text-gray-700">{{ $item->category->name }}</td>
                            <td class="py-4 px-6 text-gray-700">{{ $item->name }}</td>
                            <td class="py-4 px-6 text-gray-700 text-center">{{ $item->total }}</td>

                            {{-- Kolom Available (Logika gabungan) --}}
                            <td class="py-4 px-6 text-center">
                                <span class="font-bold {{ $available <= 0 ? 'text-red-500' : 'text-gray-700' }}">
                                    {{ $available }}
                                </span>
                            </td>

                            {{-- Kolom Lending (Link hanya untuk Admin jika ingin detail) --}}
                            <td class="py-4 px-6 text-center text-gray-700">
                                @if(Auth::user()->role === 'admin' && $lendingTotal > 0)
                                    <a href="{{ route('admin.items.lending', $item->id) }}"
                                        class="text-[#007bff] hover:underline font-medium">
                                        {{ $lendingTotal }}
                                    </a>
                                @else
                                    {{ $lendingTotal }}
                                @endif
                            </td>

                            {{-- Tombol Edit hanya untuk Admin --}}
                            @if(Auth::user()->role === 'admin')
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.items.edit', $item->id) }}"
                                        class="bg-[#6f42c1] hover:bg-[#59339e] text-white py-1 px-5 rounded text-sm transition">
                                        Edit
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'admin' ? 7 : 6 }}" class="py-10 text-center text-gray-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                Belum ada data item.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection