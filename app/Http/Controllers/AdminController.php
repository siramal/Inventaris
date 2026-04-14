<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function categories()
    {
        $categories = Category::withCount('items')->latest()->get();
        return view('admin.categories', compact('categories'));
    }
    public function createCategory()
    {
        return view('admin.category_create');
    }
    // Memproses data dari form (Untuk saat ini kita buat agar kembali ke halaman categories dulu)
    public function storeCategory(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division.required' => 'The division pj field is required.',
        ]);

        // 2. Simpan ke Database
        Category::create([
            'name' => $request->name,
            'division' => $request->division,
        ]);

        // 3. Kembali ke tabel dengan pesan sukses
        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }
    // Menampilkan Form Edit
    public function editCategory($id)
    {
        // Cari data berdasarkan ID, jika tidak ada tampilkan 404
        $category = Category::findOrFail($id);
        return view('admin.category_edit', compact('category'));
    }

    // Memproses Update Data
    public function updateCategory(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division.required' => 'The division pj field is required.',
        ]);

        // 2. Cari dan Update
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'division' => $request->division,
        ]);

        // 3. Kembali dengan pesan sukses
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }
}
