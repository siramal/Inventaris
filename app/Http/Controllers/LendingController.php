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
        return view('operator.dashboard');
    }
    public function index()
    {
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
            $stokTersedia = (int) $item->total - (int) $item->repair;
            $jumlahDipinjam = (int) $itemData['total'];

            if ($jumlahDipinjam > $stokTersedia) {
                return back()->withErrors([
                    'total_error' => "Total item more than available! (Available: $stokTersedia)"
                ])->withInput();
            }
        }

        foreach ($request->items as $itemData) {
            Lending::create([
                'name' => $request->name,
                'item_id' => $itemData['item_id'],
                'total' => $itemData['total'], 
                'notes' => $request->notes,
                'date' => now(),
                'user_id' => auth()->id(),
            ]);

            $item = Item::find($itemData['item_id']);
            $item->decrement('total', $itemData['total']);
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

        if ($lending->returned_at) {
            return redirect()->back();
        }

        // Update tanggal pengembalian
        $lending->update([
            'returned_at' => now()
        ]);

        // Tambahkan kembali jumlahnya ke kolom 'total' di tabel items
        $item = Item::find($lending->item_id);

        if ($item) {
            $item->increment('total', $lending->total);
        }

        return redirect()->back()->with('success', 'Item is returned!');
    }
}
