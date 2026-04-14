<?php

namespace App\Exports;

use App\Models\User;
use Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    // Menangkap role (admin/operator) dari Controller
    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection()
    {
        return User::where('role', $this->role)->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Password'];
    }

    public function map($user): array
    {
        // 1. Ambil 4 karakter awal email (semuanya huruf kecil agar konsisten)
        $emailPrefix = substr($user->email, 0, 4);

        // 2. Tentukan format password default (sesuai aturan Anda: prefix + 1234)
        $defaultPassword = $emailPrefix . '1234';

        // 3. Logika Pengecekan
        // Hash::check akan membandingkan teks asli ($defaultPassword) dengan hash di database
        $isStillDefault = Hash::check($defaultPassword, $user->password);

        return [
            $user->name,
            $user->email,
            // Jika masih default tampilkan passwordnya, jika sudah diubah tampilkan pesan khusus
            $isStillDefault
                ? $defaultPassword
                : 'This account already edited the password',
        ];
    }
}
