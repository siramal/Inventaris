<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Menampilkan tabel items untuk Admin dan Operator
     */
    public function index()
    {
        // 1. Ambil data dasar dengan kategori
        $query = Item::with('category');

        // 2. Jika login sebagai Admin: Hitung jumlah peminjaman (count)
        if (Auth::user()->role === 'admin') {
            $items = $query->withCount('lendings')->latest()->get();
        } 
        // 3. Jika login sebagai Operator: Hitung total barang yang sedang dipinjam (sum total)
        else {
            $items = $query->withCount(['lendings as total_dipinjam' => function ($query) {
                $query->whereNull('returned_at')->select(DB::raw('sum(total)'));
            }])->get();
        }

        // Return ke file view gabungan yang sama
        return view('items.index', compact('items'));
    }

    // --- Fungsi lainnya (createItem, storeItem, editItem, updateItem) tetap sama ---
    
    public function createItem()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:1',
        ]);

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => 0,
        ]);

        return redirect()->route('admin.items')->with('success', 'Item berhasil ditambahkan!');
    }

    public function editItem($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|integer|min:1',
            'new_broke_item' => 'required|integer|min:0',
        ]);

        $item = Item::findOrFail($id);
        $total_repair_baru = $item->repair + $request->new_broke_item;

        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => $total_repair_baru,
        ]);

        return redirect()->route('admin.items')->with('success', 'Item berhasil diperbarui!');
    }

    public function showLending($id)
    {
        return view('items.lending_detail', ['id' => $id]);
    }
}