<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Mengambil data item beserta kategori
        return Item::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Item Name',
            'Total Stock',
            'Repair/Broken',
        ];
    }
    public function map($item): array
    {
        $available = $item->total - $item->repair;

        return [
            $item->id,
            $item->category->name,
            $item->name,
            $item->total,   
            $available,
            $item->repair,
        ];
    }
}