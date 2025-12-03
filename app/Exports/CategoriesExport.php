<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Category::whereNull('deleted_at')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kategori',
            'Tipe',
            'Deskripsi'
        ];
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->type,
            $category->description ?? '-'
        ];
    }
}
