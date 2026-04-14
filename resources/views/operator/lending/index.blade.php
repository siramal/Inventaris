@extends('layouts.app')

@section('title', 'Lending Table')
@section('content')
    <div class="bg-white rounded-md shadow-md p-8">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Lending Table</h2>
                <p class="text-gray-500 text-sm mt-1">Data of <span class="text-pink-500">.lendings</span></p>
            </div>
            <div class="flex gap-3">
                <a href="" {{-- Jika sudah ada rute export --}}
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white py-2 px-6 rounded transition">
                    Export Excel
                </a>

                <a href="{{ route('operator.lending.create') }}"
                    class="bg-[#20c997] hover:bg-[#1ba87e] text-white py-2 px-6 rounded transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-600">
                    <th class="py-4 px-6 font-medium">#</th>
                    <th class="py-4 px-6 font-medium">Item</th>
                    <th class="py-4 px-6 font-medium">Total</th>
                    <th class="py-4 px-6 font-medium">Name</th>
                    <th class="py-4 px-6 font-medium">Ket.</th>
                    <th class="py-4 px-6 font-medium">Date</th>
                    <th class="py-4 px-6 font-medium">Returned</th>
                    <th class="py-4 px-6 font-medium text-center">Edited By</th>
                    <th class="py-4 px-6 font-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($lendings as $lending)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-5 px-6">{{ $loop->iteration }}</td>
                        <td class="py-5 px-6">{{ $lending->item?->name ?? 'Item Terhapus' }}</td>
                        <td class="py-5 px-6">{{ $lending->total }}</td>
                        <td class="py-5 px-6">{{ $lending->name }}</td>
                        <td class="py-5 px-6">{{ $lending->notes }}</td>
                        <td class="py-5 px-6">{{ $lending->date->format('d F, Y') }}</td>

                        <td class="py-5 px-6">
                            @if ($lending->returned_at)
                                <span
                                    class="inline-block border border-emerald-400 text-emerald-500 px-4 py-1 rounded text-sm font-medium">
                                    {{ $lending->returned_at->format('d F, Y') }}
                                </span>
                            @else
                                <span
                                    class="inline-block border border-yellow-400 text-yellow-500 px-4 py-1 rounded text-sm italic">
                                    not returned
                                </span>
                            @endif
                        </td>

                        <td class="py-5 px-6 font-bold text-[#050A30] text-center">
                            {{ $lending->user->name }}
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex justify-center gap-2">
                                @if (!$lending->returned_at)
                                    <form action="{{ route('operator.lending.returned', $lending->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-[#ffb848] hover:bg-[#e6a641] text-[#050A30] py-2 px-6 rounded-md text-sm font-bold transition shadow-sm">
                                            Returned
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('operator.lending.destroy', $lending->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-[#f56565] hover:bg-[#e53e3e] text-white py-2 px-6 rounded-md text-sm font-bold transition shadow-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-10 text-center text-gray-400 italic">
                            No lending records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection