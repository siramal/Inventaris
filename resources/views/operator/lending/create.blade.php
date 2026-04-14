@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-md shadow-md p-8 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-[#050A30] mb-2">Lending Form</h2>

        {{-- Tampilkan Error untuk Debugging --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('operator.lending.store') }}" method="POST" id="lending-form">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Borrower Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 border rounded-md bg-gray-50 focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <div id="items-container" class="space-y-4">
                {{-- Baris Pertama (Index 0) --}}
                <div class="item-group p-5 border rounded-lg bg-gray-50 relative" data-index="0">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Item</label>
                            <select name="items[0][item_id]"
                                class="item-select w-full px-4 py-3 border rounded-md bg-white focus:ring-2 focus:ring-blue-400 outline-none"
                                required>
                                <option value="" disabled selected>Select Item</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <p class="stock-info text-xs mt-1 font-medium text-gray-400"></p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Total</label>
                            <input type="number" name="items[0][total]" min="1" required
                                class="w-full px-4 py-3 border rounded-md bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="add-item-btn"
                class="mt-4 text-cyan-500 flex items-center gap-1 text-sm font-medium hover:underline">
                <i class="fa-solid fa-plus text-[10px]"></i> Add More Items
            </button>

            <div class="my-6">
                <label class="block text-gray-700 font-medium mb-2">Notes</label>
                <textarea name="notes" rows="3"
                    class="w-full px-4 py-3 border rounded-md bg-gray-50 focus:ring-2 focus:ring-blue-400 outline-none">{{ old('notes') }}</textarea>
            </div>

            {{-- Signature Pad --}}
            <div class="mb-8">
                <label class="block text-gray-700 font-medium mb-2">Digital Signature</label>
                <div class="border-2 border-dashed border-gray-200 rounded-md p-2 bg-gray-50">
                    <canvas id="signature-pad"
                        class="w-full h-40 bg-white border rounded touch-none cursor-crosshair"></canvas>
                </div>
                <button type="button" id="clear-signature" class="mt-2 text-xs text-red-500 hover:underline">Clear
                    Signature</button>
                <input type="hidden" name="signature" id="signature-input">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-[#6f42c1] hover:bg-[#59339e] text-white font-bold py-3 px-10 rounded-md shadow-md transition">Submit
                    Lending</button>
                <a href="{{ route('operator.lending.index') }}"
                    class="py-3 px-10 border rounded-md font-bold text-gray-600 hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, { backgroundColor: 'rgb(255, 255, 255)' });
        const container = document.getElementById('items-container');
        const signatureInput = document.getElementById('signature-input');
        const lendingForm = document.getElementById('lending-form');
        let itemIndex = 1;

        // Fix Canvas Scaling
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        document.getElementById('clear-signature').addEventListener('click', () => signaturePad.clear());

        // LOGIC ADD ITEM (Memperbaiki Index Array)
        document.getElementById('add-item-btn').addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = "item-group p-5 border rounded-lg bg-gray-50 relative mt-4";
            div.innerHTML = `
                <button type="button" class="remove-btn absolute top-2 right-2 text-red-500 text-xl">×</button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Item</label>
                        <select name="items[${itemIndex}][item_id]" class="item-select w-full px-4 py-3 border rounded-md bg-white focus:ring-2 focus:ring-blue-400 outline-none" required>
                            <option value="" disabled selected>Select Item</option>
                            @foreach ($items as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach
                        </select>
                        <p class="stock-info text-xs mt-1 font-medium text-gray-400"></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Total</label>
                        <input type="number" name="items[${itemIndex}][total]" min="1" required class="w-full px-4 py-3 border rounded-md bg-white focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                </div>
            `;
            container.appendChild(div);
            itemIndex++;
        });

        // Remove Item
        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-btn')) e.target.closest('.item-group').remove();
        });

        // Real-time Stock Check
        container.addEventListener('change', async (e) => {
            if (e.target.classList.contains('item-select')) {
                const info = e.target.parentElement.querySelector('.stock-info');
                const res = await fetch(`/api/items/${e.target.value}/stock`);
                const data = await res.json();
                info.innerText = `Available: ${data.stock}`;
                info.className = `stock-info text-xs mt-1 font-medium ${data.stock <= 0 ? 'text-red-500' : 'text-green-600'}`;
            }
        });

        // SUBMIT LOGIC
        lendingForm.addEventListener('submit', (e) => {
            if (signaturePad.isEmpty()) {
                alert("Harap tanda tangan terlebih dahulu!");
                e.preventDefault();
                return;
            }
            signatureInput.value = signaturePad.toDataURL(); // Masukkan gambar TTD ke input hidden
        });
    </script>
@endsection