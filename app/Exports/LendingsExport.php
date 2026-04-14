<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Mengambil data dengan relasi agar tidak berat (Eager Loading)
        return Lending::with(['item', 'user'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Jumlah',
            'Nama Peminjam',
            'Keterangan',
            'Tanggal Pinjam',
            'Status Kembali',
            'Operator (Edited By)'
        ];
    }

    public function map($lending): array
    {
        static $no = 0;
        return [
            ++$no,
            $lending->item?->name ?? 'Item Terhapus',
            $lending->total,
            $lending->name,
            $lending->notes ?? '-',
            $lending->date->format('d-m-Y'),
            $lending->returned_at ? 'Sudah Kembali (' . $lending->returned_at->format('d-m-Y') . ')' : 'Belum Kembali',
            $lending->user->name,
        ];
    }
}