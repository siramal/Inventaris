<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class ItemsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = Item::with('category');

        // Filter jika tanggal diisi
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        }

        return $query;
    }

    public function headings(): array
    {
        return ['ID', 'Category', 'Name', 'Total', 'Available', 'Created At'];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->category->name,
            $item->name,
            $item->total,
            $item->total - ($item->repair),
            $item->created_at->format('d-m-Y'),
        ];
    }
}