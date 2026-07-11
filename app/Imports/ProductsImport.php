<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;


class ProductsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        $product = Product::where('sku', $row['sku'])->first();

        if ($product) {

            $product->update([
                'category_id'=>$row['category_id'],
                'brand_id'=>$row['brand_id'],
                'name'=>$row['name'],
                'slug'=>Str::slug($row['name']),
                'price'=>$row['price'],
                'discount_price'=>$row['discount_price'],
                'stock'=>$row['stock'],
                'description'=>$row['description'],
                'status'=>$row['status'],
                'featured'=>$row['featured'],
            ]);

            return null;
        }

        return new Product([
            'category_id'=>$row['category_id'],
            'brand_id'=>$row['brand_id'],
            'name'=>$row['name'],
            'slug'=>Str::slug($row['name']),
            'sku'=>$row['sku'],
            'price'=>$row['price'],
            'discount_price'=>$row['discount_price'],
            'stock'=>$row['stock'],
            'description'=>$row['description'],
            'status'=>$row['status'],
            'featured'=>$row['featured'],
        ]);
    }

    public function rules(): array
    {
        return [

            '*.category_id'=>'required|exists:categories,id',

            '*.brand_id'=>'required|exists:brands,id',

            '*.name'=>'required|max:255',

            '*.sku'=>'required|max:100',

            '*.price'=>'required|numeric|min:0',

            '*.discount_price'=>'nullable|numeric',

            '*.stock'=>'required|integer|min:0',

            '*.status'=>'nullable|boolean',

            '*.featured'=>'nullable|boolean',

        ];
    }
}
