<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        // Mengambil semua item beserta nama kategorinya
        $items = Item::with('category')->latest()->get();

        foreach ($items as $item) {
            $item->lending_count = 0;
        }

        return view('admin.items', compact('items'));
    }
     public function operator()
    {
        // Mengambil data item dan menghitung jumlah total barang yang sedang dipinjam (returned_at is null)
        $items = Item::withCount(['lendings as total_dipinjam' => function ($query) {
            $query->whereNull('returned_at')->select(DB::raw('sum(total)'));
        }])->with('category')->get();

        return view('operator.items.index', compact('items'));
    }
    public function createItem()
    {
        // Ambil semua data kategori dari database
        $categories = Category::all();

        return view('admin.item_create', compact('categories'));
    }
    public function storeItem(Request $request)
    {
        // 1. Validasi Input form Add Item dengan pesan kustom
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:1',
        ], [
            'name.required' => 'The name field is required.',
            'category_id.required' => 'The category field is required.',
            'total.required' => 'The total field is required.',
        ]);

        // 2. Simpan ke Database
        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => 0, // Default barang baru tidak ada yang rusak
        ]);

        // 3. Kembali ke tabel
        return redirect()->route('admin.items')->with('success', 'Item berhasil ditambahkan!');
    }

    public function showLending($id)
    {
        return view('admin.item_lending_detail', ['id' => $id]);
    }
    // Menampilkan form edit item
    public function editItem($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all(); // Mengambil data kategori untuk dropdown

        return view('admin.item_edit', compact('item', 'categories'));
    }
    // Memproses pembaruan data
    public function updateItem(Request $request, $id)
    {
        // 1. Validasi Input form
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:1',
            'new_broke_item' => 'required|integer|min:0', // Validasi input barang rusak baru
        ], [
            'name.required' => 'The name field is required.',
            'category_id.required' => 'The category field is required.',
            'total.required' => 'The total field is required.',
            'new_broke_item.required' => 'The broke item field is required.',
        ]);

        // 2. Cari data item saat ini
        $item = Item::findOrFail($id);

        // 3. Logika Penjumlahan Barang Rusak
        // Total repair = repair lama + input repair baru dari form
        $total_repair_baru = $item->repair + $request->new_broke_item;

        // 4. Update ke database
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => $total_repair_baru, // Masukkan total repair yang baru dijumlahkan
        ]);

        // 5. Kembali ke tabel items
        return redirect()->route('admin.items')->with('success', 'Item berhasil diperbarui!');
    }
}
