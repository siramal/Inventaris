<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LendingController extends Controller
{
    public function dashboard()
    {
        // Arahkan ke view dashboard operator Anda
        return view('operator.dashboard');
    }
    public function index()
    {
        // Ambil data dengan eager loading agar tidak berat
        $lendings = Lending::with(['item', 'user'])->orderBy('date', 'desc')->get();
        return view('operator.lending.index', compact('lendings'));
    }

    public function create()
    {
        $items = Item::all();
        return view('operator.lending.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'items' => 'required|array',
            'notes' => 'required'
        ]);

        foreach ($request->items as $itemData) {
            $item = Item::find($itemData['item_id']);

            // HITUNG STOK TERSEDIA: Total Barang - Barang Rusak
            // Gunakan nama kolom 'total' sesuai migration Anda
            $stokTersedia = (int) $item->total - (int) $item->repair;
            $jumlahDipinjam = (int) $itemData['total'];

            if ($jumlahDipinjam > $stokTersedia) {
                return back()->withErrors([
                    'total_error' => "Total item more than available! (Available: $stokTersedia)"
                ])->withInput();
            }
        }

        // Jika aman, lakukan simpan dan kurangi kolom 'total'
        foreach ($request->items as $itemData) {
            Lending::create([
                'name' => $request->name,
                'item_id' => $itemData['item_id'],
                'total' => $itemData['total'], // jumlah yang dipinjam
                'notes' => $request->notes,
                'date' => now(),
                'user_id' => auth()->id(),
            ]);

            $item = Item::find($itemData['item_id']);
            $item->decrement('total', $itemData['total']); // Kurangi kolom 'total' di tabel items
        }

        return redirect()->route('operator.lending.index')->with('success', 'Success add new lending!');
    }
    public function destroy($id)
    {
        Lending::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Lending record deleted!');
    }
    public function markAsReturned($id)
    {
        $lending = Lending::findOrFail($id);

        // Pastikan barang belum dikembalikan untuk menghindari double stok
        if ($lending->returned_at) {
            return redirect()->back();
        }

        // 1. Update tanggal pengembalian
        $lending->update([
            'returned_at' => now()
        ]);

        // 2. Tambahkan kembali jumlahnya ke kolom 'total' di tabel items
        $item = Item::find($lending->item_id);

        if ($item) {
            $item->increment('total', $lending->total);
        }

        return redirect()->back()->with('success', 'Item is returned!');
    }
}
