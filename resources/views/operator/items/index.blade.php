@extends('layouts.app')

@section('title', 'Items Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-[#050A30]">Items Table</h2>
            <p class="text-gray-500 text-sm mt-1">Data of <span class="text-pink-500">.items</span></p>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-600">
                    <th class="py-4 px-6 font-medium">#</th>
                    <th class="py-4 px-6 font-medium">Category</th>
                    <th class="py-4 px-6 font-medium">Name</th>
                    <th class="py-4 px-6 font-medium">Total</th>
                    <th class="py-4 px-6 font-medium">Available</th>
                    <th class="py-4 px-6 font-medium">Lending Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    @php
                        // Logika: Total - (Lending yang belum kembali + Repair)
                        $lendingTotal = $item->total_dipinjam ?? 0;
                        $available = $item->total - ($lendingTotal + $item->repair);
                    @endphp
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-5 px-6">{{ $loop->iteration }}</td>
                        <td class="py-5 px-6">{{ $item->category->name }}</td>
                        <td class="py-5 px-6">{{ $item->name }}</td>
                        <td class="py-5 px-6">{{ $item->total }}</td>
                        <td class="py-5 px-6">
                            {{-- Menampilkan angka Available --}}
                            <span class="font-bold {{ $available <= 0 ? 'text-red-500' : 'text-gray-700' }}">
                                {{ $available }}
                            </span>
                        </td>
                        <td class="py-5 px-6 text-center">
                            {{ $lendingTotal }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
