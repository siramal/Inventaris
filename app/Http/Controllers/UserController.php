<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function indexAdmin()
    {
        // Mengambil semua user yang memiliki role 'admin'
        $users = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();

        // Kirim data ke view menggunakan compact
        return view('admin.users.admin', compact('users'));
    }
    // Menampilkan form tambah admin
    public function createAdmin()
    {
        return view('admin.users.admin_create');
    }

    // Memproses form tambah admin
    public function storeAdmin(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,operator', // Sesuai enum database
        ]);

        // Generate Password 4 huruf email + 1234
        $emailPrefix = substr($request->email, 0, 4);
        $generatedPassword = $emailPrefix . '1234';

        // Simpan
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($generatedPassword), // Hash password
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.admin')->with('success', "Akun berhasil dibuat! Password default: $generatedPassword");
    }
    public function editAdmin($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.users.admin_edit', compact('admin'));
    }
    public function updateAdmin(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Pastikan email unik kecuali untuk user ini sendiri
            'new_password' => 'nullable|min:8',
        ]);

        // Ambil data asli dari Database
        $admin = User::findOrFail($id);

        // Update Name dan Email
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Logika Update Password (Hanya jika diisi)
        if ($request->filled('new_password')) {
            $admin->password = Hash::make($request->new_password);
        }
        // Simpan perubahan ke database
        $admin->save();

        return redirect()->route('admin.users.admin')->with('success', 'Account updated successfully!');
    }
    public function destroyAdmin($id)
    {
        // Cari user berdasarkan ID
        $admin = User::findOrFail($id);

        // Hapus data dari database
        $admin->delete();

        // Kembali ke halaman tabel dengan pesan sukses
        return redirect()->route('admin.users.admin')->with('success', 'Account has been deleted successfully!');
    }
    public function indexOperator()
    {
        // Hanya ambil user dengan role operator
        $users = User::where('role', 'operator')->orderBy('created_at', 'desc')->get();
        return view('admin.users.operator', compact('users'));
    }

    public function createOperator()
    {
        return view('admin.users.admin_create');
    }

    public function storeOperator(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $emailPrefix = substr($request->email, 0, 4);
        $generatedPassword = $emailPrefix . '1234';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($generatedPassword),
            'role' => 'operator', // Langsung set sebagai operator
        ]);

        return redirect()->route('admin.users.operator')->with('success', "Operator berhasil dibuat! Password: $generatedPassword");
    }

    public function editOperator($id)
    {
        $operator = User::where('id', $id)->where('role', 'operator')->firstOrFail();
        return view('admin.users.operator_edit', compact('operator'));
    }

    public function updateOperator(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'new_password' => 'nullable|min:8',
        ]);

        $operator = User::findOrFail($id);
        $operator->name = $request->name;
        $operator->email = $request->email;

        if ($request->filled('new_password')) {
            $operator->password = Hash::make($request->new_password);
        }

        $operator->save();
        return redirect()->route('admin.users.operator')->with('success', 'Data operator berhasil diupdate!');
    }

    public function destroyOperator($id)
    {
        $operator = User::findOrFail($id);
        $operator->delete();
        return redirect()->route('admin.users.operator')->with('success', 'Operator berhasil dihapus!');
    }
    public function exportAdmin()
    {
        return Excel::download(new UsersExport('admin'), 'admin-accounts.xlsx');
    }

    public function exportOperator()
    {
        return Excel::download(new UsersExport('operator'), 'operator-accounts.xlsx');
    }
    public function resetPasswordOperator($id)
    {
        $user = User::findOrFail($id);

        $emailPrefix = substr($user->email, 0, 4);
        $newPassword = $emailPrefix . $user->id;

        // Update password di database
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->back()->with('success', "Password for {$user->name} has been reset to: <strong>{$newPassword}</strong>");
    }
}
