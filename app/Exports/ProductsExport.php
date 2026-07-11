<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with(['category', 'brand'])
            ->get()
            ->map(function ($product) {
                return [
                    'ID' => $product->id,
                    'Name' => $product->name,
                    'SKU' => $product->sku,
                    'Category' => $product->category?->name,
                    'Brand' => $product->brand?->name,
                    'Price' => $product->price,
                    'Discount Price' => $product->discount_price,
                    'Stock' => $product->stock,
                    'Status' => $product->status ? 'Active' : 'Inactive',
                    'Featured' => $product->featured ? 'Yes' : 'No',
                    'Created At' => $product->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Category',
            'Brand',
            'Price',
            'Discount Price',
            'Stock',
            'Status',
            'Featured',
            'Created At',
        ];
    }
}
