<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\LendingsExport;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
    public function dashboard()
    {
        return view('operator.dashboard');
    }

    public function index()
    {
        // Menggunakan Eager Loading agar tidak berat saat load data
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
            'name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.total' => 'required|integer|min:1',
            'signature' => 'required',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->items as $data) {
                $item = Item::withCount([
                    'lendings' => function ($q) {
                        $q->whereNull('returned_at');
                    }
                ])->lockForUpdate()->findOrFail($data['item_id']);

                $available = $item->total - ($item->lendings_count + $item->repair);

                if ($data['total'] > $available) {
                    DB::rollBack();
                    return back()->withErrors(['total_error' => "Stok {$item->name} tidak cukup (Tersedia: {$available})"])->withInput();
                }

                // Simpan data
                Lending::create([
                    'item_id' => $data['item_id'],
                    'user_id' => auth()->id(),
                    'name' => $request->name,
                    'total' => $data['total'],
                    'notes' => $request->notes,
                    'signature' => $request->signature,
                    'date' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('operator.lending.index')->with('success', 'Peminjaman berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Jika gagal, hentikan aplikasi dan tunjukkan pesan error-nya
            dd($e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('total_error', 'Something went wrong. Please try again.');
        }
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
            return redirect()->back()->with('info', 'Item was already returned.');
        }

        // CUKUP UPDATE returned_at
        // Stok Available akan otomatis bertambah karena lendings_count (whereNull returned_at) akan berkurang
        $lending->update([
            'returned_at' => now()
        ]);

        return redirect()->back()->with('success', 'Item has been marked as returned!');
    }
    public function exportExcel(Request $request)
    {
        // Ambil tanggal dari input
        $from = $request->get('from_date');
        $to = $request->get('to_date');

        $fileName = 'laporan-peminjaman';
        if ($from && $to) {
            $fileName .= "-($from-sampai-$to)";
        }

        return Excel::download(new LendingsExport($from, $to), $fileName . '.xlsx');
    }
}