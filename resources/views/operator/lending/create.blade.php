@extends('layouts.app')

@section('title', 'Lending Form')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-[#050A30]">Lending Form</h2>
            <p class="text-gray-500 text-sm mt-1">Please <span class="text-pink-500">.fill-all</span> input form with right
                value.</p>
        </div>

        @if ($errors->has('total_error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg text-lg">
                {{ $errors->first('total_error') }}
            </div>
        @endif

        <form action="{{ route('operator.lending.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name"
                    class="w-full px-4 py-3 rounded-md border border-gray-100 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div id="items-container" class="space-y-4">
                <div class="item-group p-5 border border-gray-200 rounded-lg bg-gray-50 relative">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Items</label>
                            <select name="items[0][item_id]"
                                class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                                <option value="" disabled selected>Select Items</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} (Stock: {{ $item->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Total</label>
                            <input type="number" name="items[0][total]" placeholder="total item"
                                class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-6">
                <button type="button" id="add-item-btn"
                    class="text-cyan-500 flex items-center gap-1 text-sm font-medium hover:text-cyan-600 transition">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i> More
                </button>
            </div>
            <div class="mb-8">
                <label class="block text-gray-700 font-medium mb-2">Ket.</label>
                <textarea name="notes" rows="4" placeholder="Keterangan peminjaman..."
                    class="w-full px-4 py-3 rounded-md border border-gray-100 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 transition @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-bold py-3 px-10 rounded-md transition shadow-md">
                    Submit
                </button>
                <a href="{{ route('operator.lending.index') }}"
                    class="bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold py-3 px-10 rounded-md transition border border-gray-100">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;
        const container = document.getElementById('items-container');
        const addButton = document.getElementById('add-item-btn');

        addButton.addEventListener('click', () => {
            const newItemDiv = document.createElement('div');
            newItemDiv.className =
                "item-group p-5 border border-gray-200 rounded-lg bg-gray-50 relative mt-4 animate-fade-in";

            newItemDiv.innerHTML = `
            <button type="button" class="remove-item-btn absolute top-3 right-3 text-red-500 hover:text-red-700 transition">
                <i class="fa-solid fa-square-xmark text-xl"></i>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Items</label>
                    <select name="items[${itemIndex}][item_id]" class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                        <option value="" disabled selected>Select Items</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (Stock: {{ $item->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Total</label>
                    <input type="number" name="items[${itemIndex}][total]" placeholder="total item" class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white focus:ring-2 focus:ring-blue-400 outline-none transition">
                </div>
            </div>
        `;

            container.appendChild(newItemDiv);
            itemIndex++;
        });

        container.addEventListener('click', (e) => {
            if (e.target.closest('.remove-item-btn')) {
                const group = e.target.closest('.item-group');
                group.classList.add('animate-fade-out'); // Tambah animasi keluar
                setTimeout(() => group.remove(), 200); // Hapus setelah animasi selesai
            }
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        .animate-fade-out {
            animation: fadeOut 0.2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    </style>
@endsection
