@extends('layouts.app')

@section('title', 'Lending Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Lending History: {{ $item->name }}</h2>
                <p class="text-gray-400 text-sm mt-1">Showing all lending records for <span
                        class="text-pink-500">{{ $item->name }}</span></p>
            </div>

            <a href="{{ route('admin.items') }}"
                class="bg-[#9E9E9E] hover:bg-gray-500 text-white font-medium py-2 px-8 rounded transition">
                Back
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="py-4 px-6 text-[#050A30] font-medium">#</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Item</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium text-center">Total</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Borrower Name</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium text-center">Signature</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Notes</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Date</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium text-center">Status</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Operator</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item->lendings as $index => $lending)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="py-5 px-6 text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-5 px-6 text-gray-700 font-medium">{{ $item->name }}</td>
                            <td class="py-5 px-6 text-gray-700 text-center">{{ $lending->total }}</td>
                            <td class="py-5 px-6 text-gray-700 capitalize">{{ $lending->name }}</td>

                            {{-- KOLOM TANDA TANGAN --}}
                            <td class="py-5 px-6 text-center">
                                @if($lending->signature)
                                    <div class="flex justify-center">
                                        <img src="{{ $lending->signature }}" alt="Tanda Tangan"
                                            class="h-12 w-auto border border-gray-200 bg-white rounded shadow-sm p-1 hover:scale-150 transition-transform duration-200">
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No signature</span>
                                @endif
                            </td>

                            <td class="py-5 px-6 text-gray-700">{{ $lending->notes ?? '-' }}</td>
                            <td class="py-5 px-6 text-gray-700">
                                {{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}
                            </td>
                            <td class="py-5 px-6 text-center">
                                @if($lending->returned_at)
                                    <span class="border border-emerald-400 text-emerald-500 py-1 px-3 text-xs font-medium rounded">
                                        returned
                                    </span>
                                @else
                                    <span class="border border-yellow-400 text-yellow-500 py-1 px-3 text-xs font-medium rounded">
                                        not returned
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-6 text-[#050A30] font-bold">
                                {{ $lending->user->name ?? 'System' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-10 text-center text-gray-400 italic">
                                No lending history found for this item.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection