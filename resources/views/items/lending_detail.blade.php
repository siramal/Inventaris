@extends('layouts.app')

@section('title', 'Lending Table')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 min-h-[400px]">

        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-xl font-bold text-[#050A30]">Lending Table</h2>
                <p class="text-gray-400 text-sm mt-1">Data of <span class="text-pink-500">.lendings</span></p>
            </div>

            <a href="{{ route('admin.items') }}"
                class="bg-[#9E9E9E] hover:bg-gray-500 text-[#050A30] font-medium py-2 px-8 rounded transition">
                Back
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="py-4 px-6 text-[#050A30] font-medium">#</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Item</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Total</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Name</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Ket.</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Date</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Returned</th>
                        <th class="py-4 px-6 text-[#050A30] font-medium">Edited By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="py-5 px-6 text-gray-700">1</td>
                        <td class="py-5 px-6 text-gray-700">Komputer</td>
                        <td class="py-5 px-6 text-gray-700">23</td>
                        <td class="py-5 px-6 text-gray-700">Pak Acep</td>
                        <td class="py-5 px-6 text-gray-700">Untuk ulangan</td>
                        <td class="py-5 px-6 text-gray-700">14 January, 2023</td>
                        <td class="py-5 px-6">
                            <span class="border border-yellow-400 text-yellow-500 py-1 px-3 text-xs font-medium">
                                not returned
                            </span>
                        </td>
                        <td class="py-5 px-6 text-[#050A30] font-bold">operator wikrama</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
@endsection
