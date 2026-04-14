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
        return view('categories.index', compact('categories'));
    }
    public function createCategory()
    {
        return view('categories.create');
    }
    // Memproses data dari form (Untuk saat ini kita buat agar kembali ke halaman categories dulu)
    public function storeCategory(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division.required' => 'The division pj field is required.',
        ]);

        // Simpan ke Database
        Category::create([
            'name' => $request->name,
            'division' => $request->division,
        ]);

        //Kembali ke tabel dengan pesan sukses
        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|in:Sarpras,Tata Usaha,tefa',
        ], [
            'name.required' => 'The name field is required.',
            'division.required' => 'The division pj field is required.',
        ]);

        //Cari dan Update
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'division' => $request->division,
        ]);

        //Kembali dengan pesan sukses
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }
}
